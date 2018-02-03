<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;



class UserController extends Controller
{
    //
	public function editUser(Request $request){
		
		if($request->mass_restrict){
			$this->validate($request,[
				'user_id'=>'required',
				'name'=>'required|max:255',
				'email'=>'required|max:255|email',
				'password'=>'required|confirmed|min:6'
			]);
			
			$user = User::where('id',$request->user_id)->first();
			
			$user->forceFill([
				'name'=> $request->name,
				'email' => $request->email,
				'password' => bcrypt($request->password),
				'remember_token' => Str::random(60),
			])->save();
			
			return redirect('users_list');
		}else{
			if($request->ip_restrict){
				$ip_restrict="yes";
			}else{
				$ip_restrict="no";
			}
			
			$this->validate($request,[
				'user_id'=>'required',
				'name'=>'required|max:255',
				'email'=>'required|max:255|email',
				'password'=>'required|confirmed|min:6',
			]);
			
			$user = User::where('id',$request->user_id)->first();
			
			$user->forceFill([
				'name' => $request->name,
				'email' => $request->email,
				'ip'=> $request->ip,
				'ip_restrict' => $ip_restrict,
				'password' => bcrypt($request->password),
				'remember_token' => Str::random(60),
			])->save();
			
			return redirect('users_list');
		}
		
		
	}

	public function show(){
        $user = JWTAuth::parseToken()->toUser();

        try{
            $user = JWTAuth::parseToken()->toUser();

            if(!$user){
                return Response::errorNotFound("User not found");
            }
        }catch(\Tymon\JWTAuth\Exceptions\TokenInvalidException $ex){
            return Response::error("Tokein is invalid");
        }catch(\Tymon\JWTAuth\Exceptions\TokenExpiredException $ex){
            return Response::error("Tokein has expired.");
        }catch(\Tymon\JWTAuth\Exceptions\TokenBlacklistedException $ex){
            return Response::error("Tokein is blacklisted");
        }

        //return Response::array(compact('user'))->setResponseCode(200);
        
        return $this->response->array(compact('user'))->setStatusCode(200);
    }

	public function getAuthors(){
		$authors = User::select('id','name','postcount')->get();

		return view('user/authors-list')->with(['authors'=>$authors, 'page_title'=>'List of authors']);
	}

	/*public function getDownload(){

		$file = 

	}*/
}
