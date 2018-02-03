<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;

class ExpenseController extends Controller
{
	public function __construct(){
		$this->middleware('admin.user');
	}
	
	public function allList(){
		$expenses = Expense::select(['id','amount','details','created_at'])->get();
		
		return view('admin/admin-expenses-list')->with(['expenses'=>$expenses]);
	}
	
	public function allChart(){
		$expenses = Expense::select(['id','amount','details','created_at'])->get();
		
		return view('admin/admin-expenses-chart')->with(['expenses'=>$expenses]);
	}
	
	public function add(Request $request){
		
		$this->validate($request,[
			'details'=>'required',
			'amount'=>'required'
		]);
		
		$data = $request->all();
		
		$expense = new Expense;
		
		$expense->fill($data);
		
		$expense->save();
		
		return redirect()->route('allExpenseList');
		
	}
	
	public function edit(Request $request){
		
		$this->validate($request,[
			'id'=>'required',
			'amount'=>'required',
			'details'=>'required'
		]);
		
		$expense = Expense::where('id',$request->id)->first();
		
		$expense->forceFill([
			'amount'=>$request->amount,
			'details'=>$request->details,
		])->save();
		
		return redirect()->route('allExpenseList');
	}
}
