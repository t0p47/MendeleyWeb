<?php
namespace App\Http\Controllers;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Folder;
use App\JournalArticle;
use Response;
use File;

class FolderController extends Controller
{
	
	public function syncAndroidFolder(Request $request){

		$user = JWTAuth::parseToken()->authenticate();

		if(!$user){
			//
			return Response::json("Fail to process action");
		}

	    $requestDevice = $request['type'];

		$folders = Folder::where('uid', $user['id'])->get();
		Folder::where("uid",$user['id'])->where("is_rename","server")->update(["is_rename"=>$requestDevice]);

		Folder::where('uid',$user['id'])->whereNotIn("is_rename",["all","server",$requestDevice])->update(["is_rename" => "all"]);

		return Response::json($folders);
	}

	public function saveCrashReport(Request $request){
		

		//$today = date("Y-m-d H:i:s"); 
		//file(storage_path($storagePath))
		//$storagePath = "app/public/crashdata.txt";
		$fileName = "Crashdata ".date("Y-m-d H;i;s").".txt";
		File::put($fileName, $request);
		return Response::json($request);
		
	}

	//TODO:Изменить название метода, т.к. он работает не только с android
	public function sendAndroidFolder(Request $request){

		$user = JWTAuth::parseToken()->authenticate();

		if(!$user){
			return Response::json("Fail to process action");
		}

		//Get JSON posted by Android Application
		$json = $request;
		//Remove Slashes
		if (get_magic_quotes_gpc()){
			$json = stripslashes($json);
		}

		 //Rest client version
		/*return "Req ".$json[0]['userName'];

	   
		return Response::json($json[0]['userName']);

		$data = json_decode($json);

		return Response::JSON($data);*/

		//Android version


		$syncType = $request['type'];

		$folderArr = $request['request'];



		$data = json_decode($folderArr);

		$resp = json_encode($data);

		//return $data[0]->name;

		$newFolderCount = 0;

		$receivedFolderIds = array();

		foreach($data as $key => $folder){

			$local_parent_id = $folder->parent_id;

			//Удаляем
			if(isset($folder->global_id)){
				if(!$this->folderExistOrDelete($folder->global_id) && $folder->global_id != 0){
					$data[$key]->is_delete=1;
					continue;
				}	
			}
			

			if(isset($folder->name)){

				$global_id = $folder->global_id;
				$title = $folder->name;

				if($folder->is_new==1){
					//return "Новая папка";
					//Первая пришедшая папка ссылается на 0(корень) или уже существующую папку
					if($newFolderCount==0){
						//Просто добавляем новую папку
						//Первая пришедшая папка ссылается на 0(корень) или уже существующую папку
						if($local_parent_id==0){
							$data[$key]->global_id = $this->createNewFolder($user->id,$title,0,$syncType);
						}else{
							$data[$key]->global_id = $this->createNewFolder($user->id,$title,$this->getGlobalParentId($local_parent_id, $data),$syncType);

							//return $key;
						}
						$newFolderCount=1;
					//Вторая пришедшая папка ссылается либо на 0(корень) или уже существующую папку либо новую папку
					}else{
						//Ссылается на корень
						if($local_parent_id==0){
							$data[$key]->global_id = $this->createNewFolder($user->id,$title,0,$syncType);
						//Ссылается на папку(новую или существующую)
						}else{
							$data[$key]->global_id = $this->createNewFolder($user->id,$title,$this->getGlobalParentId($local_parent_id, $data),$syncType);
						}
					}
				}else if($folder->is_delete==1){
					$this->deleteFolder($folder->global_id,$user->id);
				}else if($folder->is_change==1){
					//return "Изменяем существующую папку";
					if($this->renameServerFolder($global_id,$title,$syncType)==0){
						$data[$key]->global_id = -1;
					}
				}

				$receivedFolderIds[] = $global_id;
			}

			
		}

		//После того как разместили обновления из локальной версии, отправляем все папки назад на устройство

		$folderIdNames = $this->getAllFoldersIdAndName($user->id,$receivedFolderIds,$syncType);

		//TODO: В global_ids помещать только те папки(global_id), которые не были обработаны ранее...
		//TODO: * и не полность синхронизированы (is_rename != all)
		$response = [
			"local_data"=>$data,
			"global_ids"=>$folderIdNames,
			"server_received_ids"=>$receivedFolderIds
		];		

		return $response;

	}

	private function folderExistOrDelete($global_id){

		$folder = Folder::whereId($global_id)->first();
		if($folder){
			return true;
		}else{
			return false;
		}

	}

	private function getAllFoldersIdAndName($uid,$checkedIdArr,$requestDevice){

		//Если с android то нужно is_rename != all,android
		$isRenameArr = ["all",$requestDevice];
		$folders = DB::table('folders')->select("id","name","is_rename","parent_id")->
			whereNotIn("is_rename",$isRenameArr)->whereNotIn('id',$checkedIdArr)->get();

		Folder::whereNotIn('id',$checkedIdArr)->where("is_rename","server")->update(['is_rename' => $requestDevice]);

		Folder::whereNotIn('id',$checkedIdArr)->whereNotIn("is_rename",["all","server",$requestDevice])->update(['is_rename' => 'all']);

		return $folders;

	}

	private function createNewFolder($uid, $title, $parent_id,$syncType){

		$data=[
			"uid"=>$uid,
			"name"=>$title,
			"parent_id"=>$parent_id,
			"is_rename"=>$syncType
		];

		//Папка ссылается на корень
		if($parent_id==0){
			$folder = new Folder();
			$folder->fill($data);
			$folder->save();

			return $folder->id;
		//Папка является дочерней
		}else{
			$haveParentFolder = Folder::whereId($parent_id)->first();
			if($haveParentFolder){

				$folder = new Folder();
				$folder->fill($data);
				$folder->save();

				return $folder->id;
			}else{
				return 0;
			}
		}
	}

	//TODO: Поиск элемента в массиве объектов с помощью foreach долго(нужно придумать что-нибудь попроще)
	private function getGlobalParentId($local_parent_id, $data){
		$global_parent_id = null;
		foreach($data as $folder){
			if($local_parent_id == $folder->local_id){
				$global_parent_id = $folder->global_id;
				break;
			}
		}
		return $global_parent_id;
	}

	private function renameServerFolder($global_id,$title,$syncType){

		$folder = Folder::whereId($global_id)->first();
		if($folder){
			$folder->forceFill([
				"name" => $title,
				"is_rename"=>$syncType,
			])->save();
			return 1;
		}else{
			return 0;
		} 
	}

	public function deleteFolder($folder_id,$user_id){

		$deleteFolder = Folder::where('id',$folder_id)->first();
		if($deleteFolder){
			if(Folder::where('parent_id',$folder_id)->get()->count() > 0){
				$this->deleteSubfolders($folder_id,$user_id);
				$deleteFolder->delete();
			}else{
				//return Response::json("No subfolder in delete folder moveArt");
				//TODO непроверено
				$this->moveArticlesToHomeDir($folder_id,$user_id);
				$deleteFolder->delete();
			}

			return true; 
		}else{
			return false;
		}
	}

	//TODO: $user_id в наружную переменную
	//Рекурсивная функция проверки всех подпапок
	function deleteSubfolders($folder_id,$user_id){
		$subfolders1Lvl = Folder::where('parent_id',$folder_id)->get();
		foreach($subfolders1Lvl as $subfolder1Lvl){
			if(Folder::where('parent_id',$subfolder1Lvl->id)->get()->count() > 0){
				$this->deleteSubfolders($subfolder1Lvl->id,$user_id);
				$subfolder1Lvl->delete();
			}else{
				//return Response::json("No subfolder in deleteFolder subfolder moveArt");
				//TODO непроверено
				$this->moveArticlesToHomeDir($subfolder1Lvl->id,$user_id);
				$subfolder1Lvl->delete();
				dump('Папка удалена');
			}

		}
	}

	function moveArticlesToHomeDir($folder_id,$user_id){
		
		$articles = JournalArticle::where([
			['uid','=',$user_id],
			['folder','=',$folder_id],
		])->get();
		foreach($articles as $article){
			$article->folder = 0;
			$article->save();
		}
	}


	public function sendRequestBack(Request $request){



		$user = JWTAuth::parseToken()->authenticate();

		if(!$user){
			return Response::json("Fail to process action");
		}

		return "Request sended back: ".$request;

	}

	/*
	$user = JWTAuth::parseToken()->authenticate();

		if(!$user){
			return Response::json("Fail to process action");
		}

	*/
	}
