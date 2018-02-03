<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Library;
use App\JournalArticle;
use App\User;
use App\Role;
use App\Permission;
use App\Folder;
use App\Journal;
use App\UserLibrary;
use Response;

class LibraryController extends Controller
{
	protected $header;


	public function __construct(){
		$this->header = "Library";
	}



    public function testIndex(){
        return User::all();
    }

    public function attachUserRole($userId, $role){
        $user = User::find($userId);

        $roleId = Role::where('name',$role)->first();

        $user->roles()->attach($roleId);

        return $user;
    }

    public function getUserRole($userId){
        return User::find($userId)->roles;
    }

    public function attachPermission(Request $request){
        $parameters = $request->only('permission','role');

        $permissionParam = $parameters['permission'];
        $roleParam = $parameters['role'];

        $role = Role::where('name',$roleParam)->first();
        $permission = Permission::where('name',$permissionParam)->first();

        $role->attachPermission($permission);

        return $role->permissions;
        //return $this->response->created();
    }

    //Get all permissions related with a role
    public function getPermissions($roleParam){
        $role = Role::where('name',$roleParam)->first();

        //return $role->perms;
        return $this->response->array($role->perms);
    }

    //
    public function userLibrary($id){
    	
    	$user_id = Auth::user()->id;
    	$library = Library::select(['type','mid'])->where('uid',$user_id)->get();
        $articles = JournalArticle::where('uid',$id)->get();
        $journalids = array();

        $folders = Folder::select(['id','name','parent_id'])->where('uid',$user_id)->get();

        foreach($articles as $key => $article){
            $jid = $article->journal_id;

            //TODO решить как будет быстрее, много мелких запросов к БД(Journal) или один но вытаскивающий все.
            //TODO статус журнала поместить в Enum переменные
            if(array_has($journalids, $jid)){
                $article->journal_id = $journalids[$jid];
            }else{
                $tmp_journal = Journal::where('id',$jid)->first();
                $journalStatus = $this->checkJournalStatus($tmp_journal->status,$article->uid);
                if($journalStatus==0){
                    $journalids = array_add($journalids, $jid, Journal::where('id',$jid)->first()->title);
                    $article->journal_id = $journalids[$jid];
                }else if($journalStatus==1){
                    $j_title = Journal::where('id',$jid)->first()->title." на модерации";
                    $journalids = array_add($journalids, $jid, $j_title);
                    $article->journal_id = $journalids[$jid];
                }else if($journalStatus==2){
                    unset($articles[$key]);
                }
            }

            //array_has($array, 'product.name');
        }

        $arrayCategories = array();
        foreach($folders as $folder){
            $arrayCategories[$folder->id] = array("parent_id" => $folder->parent_id, "name"=>$folder->name);
        }

        return view('user/user-library')->with(['library'=>$library,'journalarticles'=>$articles,'page_title'=>$this->header,'folders'=>$arrayCategories]);
    }

    public function addOrRenameSubfolder(Request $request){
        //TODO Сделать user_id статической переменной(что бы не надо было каждый раз запрашивать)
        $user_id = Auth::user()->id;

        if($request->isrename==0){
            $parent_id = substr($request->parent_id,6);
            $name = $request->name;
            $data = [
                "uid" => $user_id,
                "name" => $name,
                "title" => "testTitle",
                "parent_id" => $parent_id,
            ];

            $folder = new Folder;
            $folder->fill($data);
            $folder->save();
            $result = [
                "id" => $folder->id,
                "name" => $name,
                "parent_id" => $request->parent_id,
            ];

            return Response::json($result);
        }else{

            $current_id = substr($request->parent_id,6);
            $name = $request->name;

            $folder = Folder::where('id',$current_id)->first();

            $folder->forceFill([
                "name" => $name,
                "is_rename" => "server"
            ])->save();
            //return Response::json($folder);

            return Response::json('true');
        }
        
    }

    public function userFolder(Request $request){
        $user_id = Auth::user()->id;
        $folderId = substr($request->folderId,6);
        $mids;
        //getArticlesInFolderById($mids,$folderId)
        $userLibrary = UserLibrary::where('reader_id',$user_id)->get();
        foreach($userLibrary as $value){
            $mids[] = $value->mid;
        }

        $articles = $this->getArticlesInFolderById($mids,$folderId);
        $articles = $this->giveArticlesJournalTitle($articles);


        for($i=0;$i<count($articles);$i++){

            $userLibKey = array_search($articles[$i]->id,$mids);
            $articles[$i]->favorite = $userLibrary[$userLibKey]->favorite;
        }
        
        return Response::json($articles);
    }

    public function allArticles(Request $request){

        $user_id = Auth::user()->id;
        $mids = array();
        $userLibrary = UserLibrary::where('reader_id',$user_id)->get();
        foreach($userLibrary as $value){
            $mids[] = $value->mid;
        }

        $articles = $this->getArticlesById($mids);

        $articles = $this->giveArticlesJournalTitle($articles);

        for($i = 0;$i<count($articles);$i++){
            $articles[$i]->favorite = $userLibrary[$i]->favorite;
        }

        return Response::json($articles);


        //$testArticle->favorite = 1;

        return Response::json($articles);

    }

    public function favoriteArticles(Request $request){

        $user_id = Auth::user()->id;
        $mids;
        $userLibrary = UserLibrary::where([
            ['favorite','=',1],
            ['reader_id','=',$user_id],
        ])->get();
        foreach($userLibrary as $value){
            $mids[] = $value->mid;
        }

        $articles = $this->getArticlesById($mids);
        for($i=0;$i < count($articles);$i++){
            $articles[$i]->favorite = 1;
        }

        return Response::json($articles);
    }

    public function myArticles(Request $request){
        $user_id = Auth::user()->id;
        $mids;
        $library = Library::where('uid',$user_id)->get();
        foreach($library as $value){
            $mids[] = $value->mid;
        }
        $userLibrary = UserLibrary::whereIn('mid',$mids)->get();

        $articles = $this->getArticlesById($mids);
        $articles = $this->giveArticlesJournalTitle($articles);
        for($i = 0;$i<count($articles);$i++){
            $articles[$i]->favorite = $userLibrary[$i]->favorite;
        }

        return Response::json($articles);

    }

    function getArticlesById($mids){

        $journalArticles = JournalArticle::whereIn('id',$mids)->get();
        return $journalArticles;

    }

    function getArticlesInFolderById($mids,$folderId){
        $journalArticles = JournalArticle::whereIn('id',$mids)->where('folder',$folderId)->get();

        return $journalArticles;
    }

    public function makeArticleFavorite(Request $request){


        $user_id = Auth::user()->id;
        $userLibrary = UserLibrary::where([
            ['reader_id','=',$user_id],
            ['mid',$request->id]
        ])->first();
        JournalArticle::whereId($request->id)->first()->touch();
        $userLibrary->forceFill([
            "favorite"=>$request->favorite,
        ])->save();

    }

    public function deleteFolder(Request $request){

        $folder_id = substr($request->folder_id,6);

        $deleteFolder = Folder::where('id',$folder_id)->first();

        if(Folder::where('parent_id',$folder_id)->get()->count() > 0){
            dump('Есть подпапки');
            $this->deleteSubfolders($folder_id);
            $deleteFolder->delete();
        }else{
            //return Response::json("No subfolder in delete folder moveArt");
            //TODO непроверено
            $this->moveArticlesToHomeDir($folder_id);
            $deleteFolder->delete();
        }

        return Response::json("true");

    }

    //Рекурсивная функция проверки всех подпапок
    function deleteSubfolders($folder_id){
        $subfolders1Lvl = Folder::where('parent_id',$folder_id)->get();
        foreach($subfolders1Lvl as $subfolder1Lvl){
            if(Folder::where('parent_id',$subfolder1Lvl->id)->get()->count() > 0){
                $this->deleteSubfolders($subfolder1Lvl->id);
                $subfolder1Lvl->delete();
            }else{
                //return Response::json("No subfolder in deleteFolder subfolder moveArt");
                //TODO непроверено
                $this->moveArticlesToHomeDir($subfolder1Lvl->id);
                $subfolder1Lvl->delete();
                dump('Папка удалена');
            }

        }
    }

    function moveArticlesToHomeDir($folder_id){
        $user_id = Auth::user()->id;
        $articles = JournalArticle::where([
            ['uid','=',$user_id],
            ['folder','=',$folder_id],
        ])->get();
        foreach($articles as $article){
            $article->folder = 0;
            $article->save();
        }
    }

    public function deleteJournalArticle(Request $request){
        $user_id = Auth::user()->id;

        //$array=json_decode($_POST['jsondata']);
        $array = json_decode($request->data);

        foreach($array as $id){
            if($id!=''){
                $article = JournalArticle::whereId($id)->get();
                //Удаляет владелец статьи
                if($article[0]->uid==$user_id){
                    //TODO: Убрать если хотим сохранить статью в системе. Заменить на вторую
                    UserLibrary::where('mid',$id)->delete();
                    /*UserLibrary::where([
                        ['mid','=',$id],
                        ['reader_id','=',$user_id],
                    ])->delete();*/

                    Library::where('mid',$id)->delete();

                    //TODO: Убрать если хотим сохранить статью в системе
                    //Если к статье присоединен файл
                    $filepath = $article[0]->filepath;
                    if($filepath!=''){
                        $this->deleteArticleFile($filepath);
                    }
                    JournalArticle::whereId($id)->delete();

                    User::whereId($user_id)->decrement('postcount');
                //Кто-то просто удаляет из своей библиотеки
                }else{
                    UserLibrary::where([
                        ['mid','=',$id],
                        ['reader_id','=',$user_id],
                    ])->delete();
                    Library::where('mid',$id)->decrement('takescount');
                    JournalArticle::whereId($id)->decrement('takescount');
                }
            }
        }
        return Response::json($array[0]);
    }

    function deleteArticleFile($path){
        $path = substr($path,9);

        return Storage::disk('public')->delete($path);
    }

    public function createJournalArticle(Request $request){
        $user_id = Auth::user()->id;

        $this->validate($request,[
            'title'=>'required',
            'authors'=>'required|max:255',
            'abstract'=>'',
            'journal_id'=>'required',
            'folder'=>'integer',
            'year'=>'integer',
            'volume'=>'integer',
            'issue'=>'integer',
            'pages'=>'integer',
            'ArXivID'=>'max:255',
            'DOI'=>'max:255',
            'PMID'=>'max:255',
            'filepath'=>''
        ]);

        $data = $request->except(['journal_id']);

        $journal_id = $this->checkJournal($request->journal_id);
        if($journal_id==false){
            $return_data = [
                "error"=>true,
                "type"=>"journal"
            ];
            return Response::json($return_data);
        }
        array_set($data,'journal_id',$journal_id);

        array_walk ($data, function(&$value){
            $value = $this->emptyToNull($value);
        });


        if($request->filepath){
            if($request->file('filepath')->isValid()){
                //$path = $request->filepath->storeAs('images/'.$user_id,'filename.pdf');
                if($request->file('filepath')->getClientSize()<26000000){
                    $originalName = $request->filepath->getClientOriginalName();
                    $path = $request->filepath->storeAs('public/'.$user_id,$originalName);
                    $url = Storage::url($path);

                    $dbFileName = '/'.$user_id.'/'.$originalName;

                    /*$response = "Path ".$path.", url ".$url.", originalName ". $originalName;
                    return view('testing')->with([
                        'responseFile'=> $response,
                    ]);*/
                }else{
                    $return_data = [
                        "error"=>true,
                        "type"=>"filesize"
                    ];
                    return Response::json($return_data);
                }
                

                array_set($data,'filepath',$dbFileName);

            }
        }

        $journalArticle = new JournalArticle;
        $journalArticle->fill($data);
        $journalArticle->save();
        $journal = Journal::where('id',$journalArticle->journal_id)->first();
        $journalStatus = $this->checkJournalStatus($journal->status,$journalArticle->uid);
        if($journalStatus==0){
            $journalArticle->journal_id = $journal->title;
        }else if($journalStatus==1){
            $journalArticle->journal_id = $journal->title." на модерации";
        }

        $insertedID = $journalArticle->id;

        $this->addToLibrary('journalarticles',$insertedID,$user_id);

        $this->addToUserLibrary($insertedID,$user_id,true);
        
        return Response::json($journalArticle);        
    }

    function checkJournalStatus($status, $uid){
        //TODO сделать статичной переменной, что бы не надо было каждый раз запрашивать
        $user_id = Auth::user()->id;
        if($status=="approved"){
            //Show to all
            return 0;
        }else if($status=="moderated" && $uid==$user_id){
            //Show only to author
            return 1;
        }else if($status=="denied" || $status=="moderated"){
            //Don't show
            return 2;
        }
    }

    function checkJournal($journal_title){
        $user_id = Auth::user()->id;
        $journal = Journal::where('title',$journal_title)->get();
        //Журнал существует
        if($journal->count()>0){
            if($journal[0]->status!='denied'){
                return $journal[0]->id;
            }else{
                return false;
            }
            

        //Журнал не существует
        }else{
            $data = [
                "title" => $journal_title,
                "uid" => $user_id,
            ];
            $journal = new Journal;
            $journal->fill($data);
            $journal->save();

            return $journal->id;
        }
    }

    function emptyToNull($string){
        if(trim($string) === ''){
            $string = null;
        }

        return $string;
    }

    function addToLibrary($type, $mid, $uid){

        $user_id = Auth::user()->id;

        User::whereId($user_id)->increment('postcount');

        $data = [
            'type'=>$type,
            'mid'=>$mid,
            'uid'=>$uid,
        ];
        $library = new Library;
        $library->fill($data);
        $library->save();
    }

    function addToUserLibrary($mid,$reader_id,$isCreator){
        $user_id = Auth::user()->id;

        $data = [
            'mid'=>$mid,
            'reader_id'=>$reader_id,
        ];

        $userLibrary = new UserLibrary;
        $userLibrary->fill($data);
        $userLibrary->save();

        if(!$isCreator){
            Library::where('mid',$mid)->increment('takescount');
            JournalArticle::where('id',$mid)->increment('takescount');
        }

    }

    public function editJournalArticle(Request $request){

        //TODO: Remove when ended
        //return Response::json($request);

        $this->validate($request,[
            'id'=>'required',
            'title'=>'required',
            'authors'=>'required|max:255',
            'abstract'=>'',
            'journal_id'=>'required',
            'folder'=>'integer',
            'year'=>'integer',
            'volume'=>'integer',
            'issue'=>'integer',
            'pages'=>'integer',
            'ArXivID'=>'max:255',
            'DOI'=>'max:255',
            'PMID'=>'max:255',
            'filepath'=>''
        ]);

        $data = $request->except(['journal_id']);

        $journal_id = $this->checkJournal($request->journal_id);
        if($journal_id==false){
            $return_data = [
                "error"=>true,
                "type"=>"journal"
            ];
            return Response::json($return_data);
        }

        array_set($data, 'journal_id',$journal_id);

        array_walk($data, function(&$value){
            $value = $this->emptyToNull($value);
        });

        //return Response::json($data);

        $journalArticle = JournalArticle::where('id',$request->id)->first();

        $journalArticle->forceFill([
            'id'=> $data['id'],
            'title'=> $data['title'],
            'authors'=> $data['authors'],
            'abstract'=> $data['abstract'],
            'journal_id'=> $data['journal_id'],
            'year'=> $data['year'],
            'volume'=> $data['volume'],
            'issue'=> $data['issue'],
            'pages'=> $data['pages'],
            'ArXivID'=> $data['ArXivID'],
            'DOI'=> $data['DOI'],
            'PMID'=> $data['PMID']
        ])->save();

        $journalArticle->forceFill([
            'journal_id'=>$request->journal_id
        ]);

        $user_id = Auth::user()->id;

        return Response::json($journalArticle);

        //return redirect()->action('LibraryController@userLibrary',['id'=>$user_id,'page_title'=>$this->header]);
    }

    public function userMendeleyLibrary($id){
        $user_id = Auth::user()->id;
        $mids;
        $userLibrary = UserLibrary::where('reader_id',$user_id)->get();


        $folders = Folder::where('uid',$user_id)->get();

        $arrayCategories = array();
        foreach($folders as $folder){
            $arrayCategories[$folder->id] = array(
                "parent_id" => $folder->parent_id,
                "name" => $folder->name
            );
        }

        $mids = array();

        foreach($userLibrary as $value){
            $mids[] = $value->mid;
        }

        $articles = $this->getArticlesById($mids);
        $articles = $this->giveArticlesJournalTitle($articles);

        for($i = 0;$i<count($articles);$i++){
            $articles[$i]->favorite = $userLibrary[$i]->favorite;
        }

        //return Response::json($articles);

        return view('user/user-library-mendeley')->with([
            'journalarticles'=>$articles,
            'page_title'=>$this->header,
            'folders'=>$arrayCategories,
        ]);
    }

    function giveArticlesJournalTitle($articles){
        $journalids = array();

        foreach($articles as $key => $article){
            $jid = $article->journal_id;

            //TODO решить как будет быстрее, много мелких запросов к БД(Journal) или один но вытаскивающий все.
            //TODO статус журнала поместить в Enum переменные
            if(array_has($journalids, $jid)){
                $article->journal_id = $journalids[$jid];
            }else{
                $tmp_journal = Journal::where('id',$jid)->first();
                $journalStatus = $this->checkJournalStatus($tmp_journal->status,$article->uid);
                if($journalStatus==0){
                    $journalids = array_add($journalids, $jid, Journal::where('id',$jid)->first()->title);
                    $article->journal_id = $journalids[$jid];
                }else if($journalStatus==1){
                    $j_title = Journal::where('id',$jid)->first()->title/*." на модерации"*/;
                    $journalids = array_add($journalids, $jid, $j_title);
                    $article->journal_id = $journalids[$jid];
                }else if($journalStatus==2){
                    unset($articles[$key]);
                }
            }
        }

        return $articles;
    }

    public function syncAndroidArticles(Request $request){

        $user = JWTAuth::parseToken()->authenticate();

        if(!$user){
            return Response::json("Fail to process action");
        }

        $syncType = $request['type'];

        $userLibrary = UserLibrary::where('reader_id',$user->id)->get();

        $mids = array();

        foreach ($userLibrary as $value){
            $mids[] = $value->mid;
        }

        $this->setSyncedWithDevice($mids,$syncType);
        $articles = $this->getArticlesById($mids);
        $articles = $this->giveArticlesJournalTitle($articles);

        for($i = 0;$i<count($articles);$i++){
            $articles[$i]->favorite = $userLibrary[$i]->favorite;
        }

        return Response::json($articles);

        //return Response::json($user->id);

    }

    function setSyncedWithDevice($mids,$requestDevice){

        JournalArticle::whereIn("id",$mids)->where("is_new","server")->update(["is_new"=>$requestDevice]);

        JournalArticle::whereIn("id",$mids)->whereNotIn("is_new",["all","server",$requestDevice])->update(["is_new" => "all"]);

    }

    public function readArticle(Request $request){
        
        if($this->checkIsArticleRead($request)>0){
            $user_id = Auth::user()->id;

            $data = [
                "mid"=>$request->id,
                "reader_id"=>$user_id,
            ];

            $userLibrary = new UserLibrary();
            $userLibrary->fill($data);
            $userLibrary->save();            

            return Response::json("success");
        }else{
            return Response::json("exist");
        }

        
    }

    function checkIsArticleRead($mid){
        $user_id = Auth::user()->id;

        $userLibrary = UserLibrary::where([
            ['mid','=',$mid],
            ['reader_id','=',$user_id],
        ])->get();

        return count($userLibrary);
    }
}