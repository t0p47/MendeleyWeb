<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\JournalArticle;
use App\Journal;
use App\User;
use App\Library;
use App\UserLibrary;
use Response;

class JournalArticleController extends Controller
{
	//
	public function getAllArticles(){

		$articles = JournalArticle::all();

		return view('user/journal-articles-list')->with(['page_title'=>'Article search','journalarticles'=>$articles]);

	}

	public function viewPdf(Request $request){

		/*$filepath = substr($request->filepath,9);

		$storagePath = "app/public/".$filepath;

		return Response::json($request->filepath);

		//WORKED
		//COMMENT return response()->file(storage_path("app/public/19/guice.pdf"));

		return response()->file(storage_path($storagePath));*/

		$storagePath = "app/public/".$request->filepath;

		return response()->file(storage_path($storagePath));
	}

	public function getArticleById($id){

		$article = JournalArticle::where('id',$id)->first();

		$journalids = array();
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
				$j_title = Journal::where('id',$jid)->first()->title;
				$journalids = array_add($journalids, $jid, $j_title);
				$article->journal_id = $journalids[$jid];
			}else if($journalStatus==2){
				unset($articles[$key]);
			}
		}

			//array_has($array, 'product.name');

		//return view('user/home');
		
		return Response::json($article);

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

	public function showSearchPage(){


		return view('search/journal-article');
	}

	public function searchJournalArticle(Request $request){

		$articles = JournalArticle::search($request->search_query)->get();
		//$articles = JournalArticle::all();


		$articles = $this->giveArticlesJournalTitle($articles); 

		
		$isOdd = count($articles)%2;
		return view('search/journal-article')->with(['articles'=>$articles,'isOdd'=>$isOdd,'type'=>'Статьи','articlesCount'=>count($articles)]);

		//return view('search/journal-article')->with(['articles'=>$articles]);

	}

	private function giveArticlesJournalTitle($articles){
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

	public function receiveWindowsFile(){

		return response()->file(storage_path("app/public/19/ParasitolUnitedJ911-2870602_004750.pdf"));

	}

	public function sendAndroidArticles(Request $request){

		$user = JWTAuth::parseToken()->authenticate();

		if(!$user){
			return Response::json("Fail to process action!");
		}

		//Get posted JSON
		$json = $request;
		//Remove slashes
		if(get_magic_quotes_gpc()){
			$json = stripslashes($json);
		}

		$syncType = $request['type'];

		$articlesArr = $request['request'];

		$data = json_decode($articlesArr);

		$newArticlesArr = array();

		
		$needToDelete = array();
		$needToSyncArr = array();
		$serverCreatedArr = $this->getNewServerArticles($user->id,$syncType);

		foreach($data as $key => $article){

			//Созданные локально(не синхронизированные)
			if(!isset($article->global_id)){
				$newToServerArr = new \stdClass();
				$newToServerArr->local_id = $article->local_id;
				$newToServerArr->global_id = $this->createJournalArticle($user->id,$article,$syncType);
				$newArticlesArr[]=$newToServerArr;
			//Сверить глобальные статьи
			}else{
				if($article->is_delete == 1){
					$this->deleteArticle($user->id,$article->global_id);
					$needToDelete[] = $article->global_id;
					continue;
				}
				$compared = $this->compareArticleDate($article->global_id,$article->updated_at);

				//Статья не существует(Удалена на сервере, удалить локально)
				if($compared == 0){
					$needToDelete[] = $article->global_id;
				//Статьи не равны
				}else{
					//Статья на сервере новее
					if($compared == 2){
						$articleServer = JournalArticle::whereId($article->global_id)->get();
						//$articles = $this->giveArticlesJournalTitle($articles);
						$articleServer = $this->giveArticlesJournalTitle($articleServer);
						$articleServer[0]->favorite = $this->getFavorite($user->id,$article->global_id);
						$articleServer->fau = 33;
						$needToSyncArr[] = $articleServer;
						//return "NeedToSyncArr";
					}
					//Статья на локальном устройстве новее
					else if($compared == 3){
						$this->updateServerArticleByLocal($user->id,$article);
						$needToSyncArr[] = 3;
					}
				}
			}	
		}

		$response = [
			"insertedArticles"=>$newArticlesArr,
			"needToSync"=>$needToSyncArr,
			"serverCreated"=>$serverCreatedArr,
			"needToDelete"=>$needToDelete
		];

		return $response;
	}

	private function updateServerArticleByLocal($uid,$article){
		//editJournalArticle
		$journal_id = $this->checkJournal($uid,$article->journal_id);

		if($journal_id==false){
			$return_data = [
				"error"=>true,
				"type"=>"journal"
			];
			return $return_data;
		}
		$article->journal_id = $journal_id;

		array_walk($article, function(&$value){
			$value = $this->emptyToNull($value);
		});

		$this->setFavorite($uid,$article->global_id,$article->favorite);

		$journalArticle = JournalArticle::whereId($article->global_id)->first();

		$journalArticle->forceFill([
            'title'=> $article->title,
            'authors'=> $article->authors,
            'abstract'=> $article->abstract,
            'journal_id'=> $article->journal_id,
            'year'=> $article->year = ($article->year==-1 ? null : $article->year),
            'volume'=> $article->volume = ($article->volume==-1 ? null : $article->volume),
            'issue'=> $article->issue = ($article->issue==-1 ? null : $article->issue),
            'pages'=> $article->pages = ($article->pages==-1 ? null : $article->pages),
            'ArXivID'=> $article->ArXivID = ($article->ArXivID==-1 ? null : $article->ArXivID),
            'DOI'=> $article->DOI = ($article->DOI==-1 ? null : $article->DOI),
            'PMID'=> $article->PMID = ($article->PMID==-1 ? null : $article->PMID),
            'folder'=>$article->folder,
            'updated_at'=>$article->updated_at,
		])->save();
	}

	private function setFavorite($uid, $mid, $favorite){

		UserLibrary::where([
			['mid',$mid],
			['reader_id',$uid]
		])->update(["favorite" => $favorite]);

	}

	private function getFavorite($uid,$mid){

		$userLib = UserLibrary::where([
			['mid',$mid],
			['reader_id',$uid]
		])->first();

		return $userLib->favorite;

	}

	private function emptyToNull($string){
        if(trim($string) === ''){
            $string = null;
        }

        return $string;
    }

	private function deleteArticle($uid, $global_id){
		$article = JournalArticle::whereId($global_id)->first();
		//Удаляет владелец статьи
		$serverUID = $article->uid;
		if($article->uid == $uid){
			//TODO: Убрать есть хотим сохранить статью в системе. Заменить на вторую
			UserLibrary::where("mid",$global_id)->delete();
			/*UserLibrary::where([
				["mid",$global_id],
				["reader_id",$uid],
			])->delete();*/

			Library::where("mid",$global_id)->delete();

			//TODO: Убрать если хотим сохранить статью в системе
            //Если к статье присоединен файл
            /*$filepath = $article[0]->filepath;
            if($filepath!=''){
                $this->deleteArticleFile($filepath);
            }*/

            JournalArticle::whereId($global_id)->delete();


			User::whereId($uid)->decrement('postcount');
		}
		//Кто-то просто удаляет из своей библиотеки
		else{
			UserLibrary::where([
				["mid",$id],
				["reader_id",$uid],
			])->delete();
			Library::where("mid",$global_id)->decrement("takescount");
			JournalArticle::whereId($global_id)->decrement("takescount");
		}
	}

	private function getNewServerArticles($uid,$requestDevice){

		$userLibrary = UserLibrary::where("reader_id",$uid)->get();

		$mids = array();

		foreach($userLibrary as $value){
			$mids[] = $value->mid;

		}

		$isNewArr = ["all",$requestDevice];

		$articles = JournalArticle::whereIn("id",$mids)->whereNotIn("is_new",$isNewArr)->get();

		$articles = $this->giveArticlesJournalTitle($articles);

		JournalArticle::whereIn("id",$mids)->where("is_new","server")->update(["is_new" => $requestDevice]);

		JournalArticle::whereIn("id",$mids)->whereNotIn("is_new",["all","server",$requestDevice])->update(["is_new" => "all"]);

		for($i = 0;$i<count($articles);$i++){
            $articles[$i]->favorite = $userLibrary[$i]->favorite;
        }

		return $articles;

	}

	private function createJournalArticle($uid, $articleArr, $requestDevice){

		$journal_id = $this->checkJournal($uid,$articleArr->journal_id);

		if($journal_id==false){
			$return_data = [
				"error"=>true,
				"type"=>"journal"
			];
			return $return_data;
		}
		$articleArr->journal_id = $journal_id;

		$data=[
			'uid' => $uid,
            'title'=> $articleArr->title,
            'authors'=> $articleArr->authors,
            'abstract'=> $articleArr->abstract,
            'journal_id'=> $articleArr->journal_id,
            'year'=> $articleArr->year = ($articleArr->year==-1 ? null : $articleArr->year),
            'volume'=> $articleArr->volume = ($articleArr->volume==-1 ? null : $articleArr->volume),
            'issue'=> $articleArr->issue = ($articleArr->issue==-1 ? null : $articleArr->issue),
            'pages'=> $articleArr->pages = ($articleArr->pages==-1 ? null : $articleArr->pages),
            'ArXivID'=> $articleArr->ArXivID = ($articleArr->ArXivID==-1 ? null : $articleArr->ArXivID),
            'DOI'=> $articleArr->DOI = ($articleArr->DOI==-1 ? null : $articleArr->DOI),
            'PMID'=> $articleArr->PMID = ($articleArr->PMID==-1 ? null : $articleArr->PMID),
            'folder'=>$articleArr->folder,
            'updated_at'=>$articleArr->updated_at,
            'is_new'=>$requestDevice,
		];

		$journalArticle = new JournalArticle();
		$journalArticle->fill($data);
		$journalArticle->save();

		$insertedID = $journalArticle->id;

		$this->addToLibrary("journalarticles",$insertedID,$uid);

		$this->addToUserLibrary($insertedID,$uid,true);

		//setFavorite($uid, $mid, $favorite)
		$this->setFavorite($uid,$insertedID,$articleArr->favorite);

		return $insertedID;
	}

	private function checkJournal($uid,$journal_title){

		$journal = Journal::where('title',$journal_title)->first();

		//Журнал существует
		if($journal){
			if($journal->status!='denied'){
				return $journal->id;
			}else{
				return false;
			}
		}
		//Журнал не существует
		else{
		   $data = [
				"title"=>$journal_title,
				"uid"=>$uid,
		   ];
		   $journal = new Journal();
		   $journal->fill($data);
		   $journal->save();
		   return $journal->id;
		}

	}

	private function addToLibrary($type,$mid,$uid){

		User::whereId($uid)->increment('postcount');

		$data = [
			"type"=>$type,
			"mid"=>$mid,
			"uid"=>$uid,
		];

		$library = new Library();
		$library->fill($data);
		$library->save();
	}

	private function addToUserLibrary($mid,$reader_id,$isCreator){

		$data = [
			"mid"=>$mid,
			"reader_id"=>$reader_id,
		];

		$userLibrary = new UserLibrary;
		$userLibrary->fill($data);
		$userLibrary->save();

		if(!$isCreator){
			Library::where("mid",$mid)->increment("takescount");
			JournalArticle::whereId($mid)->increment("takescount");
		}

	}

	private function compareArticleDate($global_id, $updated_at){

		$article = JournalArticle::whereId($global_id)->first();

		if($article){
			if($article->updated_at!=$updated_at){

				$server_update_time = strtotime($article->updated_at);
				$local_update_time = strtotime($updated_at);

				//Сервер был обновлен последним
				if($server_update_time>$local_update_time){
					return 2;
				}
				//Локальное устройство было обновлено первым
				else{
					return 3;
				}
			}else{
				return 1;
			}
		}else{
			return 0;
		}
	}

	public function sendRequestBack(Request $request){

		$user = JWTAuth::parseToken()->authenticate();

		if(!$user){
			return Response::json("Fail to process action");
		}

		return $request;

	}
}