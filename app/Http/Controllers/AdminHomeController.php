<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\AdminUser;
use Auth;

class AdminHomeController extends Controller
{
    //
	public function __construct(){
		$this->middleware('admin.user');
	}
	
	public function index(){
		
		//dd('admin_home index');
		$admin = AdminUser::select(['ip','ip_restrict'])->first();
		
		return view('admin/admin-home')->with(['admin'=>$admin]);
	}
	
	public function usersList(){
		
		$admin = AdminUser::select('ip_restrict')->first();
		$ip_restrict = $admin->ip_restrict;
		
		$users = User::select(['id','name','email','ip_restrict','ip','postcount'])->get();
		
		return view('admin/admin-users-list')->with(['users'=>$users,'ip_restrict'=>$ip_restrict]);
	}
	
	public function massIpRestrict(Request $request){
		
		$this->validate($request,[
			'ip'=>'required',
			'ip_restrict'=>'required',
		]);
		
		$admin = AdminUser::first();
		
		$admin->forceFill([
			'ip'=>$request->ip,
			'ip_restrict'=>$request->ip_restrict,
		])->save();
		
		return redirect('admin_home');
	}
	
	public function userData($id){
	
		
		return view('user-data')->with(['id'=>$id]);
	}
}