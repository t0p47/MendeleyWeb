<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class TransactionController extends Controller
{
	protected $header;
	protected $user;
	protected $admin_user = "admin_user";
	protected $simple_user = "web";
	protected $endcoll;
	protected $counter;
	
	public function __construct(){
		
		$this->middleware('nobody.user');
		
		$this->header = "Default header";
		
	}
	
	
    //
	public function allList(){
		
		//$transactions = User::find(4)->transactions;
		
		/*$transactions = Transaction::with('user')->get();
		
		foreach($transactions as $transaction){
			//dump($transaction->id);
			dump($transaction->user->name);
		}
		
		dd('end');*/
		
		//Администратор
		if(Auth::guard($this->admin_user)->check()){
			
			//$transactions = Transaction::select(['id','user_id','type','amount','details','ip','created_at','updated_at'])->get();
			
			$transactions = Transaction::with('user')->get();
			
			$users = User::select(['id','name'])->get();
	  
			$this->header = "All transactions list";
			
			return view('admin/admin-transactions-list')->with(['transactions'=>$transactions, 'users'=>$users,'header'=>$this->header]);
			
		//Пользователь
		}elseif(Auth::guard($this->simple_user)){
			
			$user_id = Auth::user()->id;
			
			$transactions = Transaction::select(['amount','created_at'])->where('user_id',$user_id)->get();
		
			$this->header = "My transactions chart";
			
			return view('user/user-transactions-list')->with(['transactions'=>$transactions,'header'=>$this->header]);
			
		}
	}
	
	public function allChart(){
		
		//Администратор
		if(Auth::guard($this->admin_user)->check()){
			
			$transactions = Transaction::with('user')->get();
			
			$users = User::select(['id','name'])->get();
			
			$this->header = "All transactions chart";
			
			return view('admin/admin-transactions-chart')->with(['transactions'=>$transactions,'users'=>$users, 'header'=>$this->header]);
		//Пользователь
		}elseif(Auth::guard($this->simple_user)){
			
			$user_id = Auth::user()->id;
			
			$transactions = Transaction::select(['amount','created_at'])->where('user_id',$user_id)->get();
			
			$this->header = "My transactions chart";
			
			return view('user/user-transactions-chart')->with(['transactions'=>$transactions,'header'=>$this->header]);
		}
	}
	
	public function busyDays(Request $request){
		
		$this->header = "All transactions chart";
		
		$transactions = Transaction::select(['amount','created_at'])->get();

		$multiplied = $transactions->map(function ($item, $key) {
			$created_atTS = array_get($item->toArray(),'created_at');
			$dt = Carbon::parse($created_atTS);
			$item->created_at = $dt->toDateString();
			return $key;
		});
		
		//Перенос модели транзкции в массив
		$data = array();
		$this->counter = 0;
		
		//Уникальные даты
		$dates = array();
		
		//MIDDLE
		if($request->start_date && $request->end_date){
			//dump($request->start_date);
			
			foreach($transactions as $transaction){
				$arr = $transaction->toArray();
				global $dates, $data;
				$carb = Carbon::parse($arr['created_at']);
				
				//Проверка входимость в разницу дат
				if($carb->lte(Carbon::parse($request->end_date)) && $carb->gte(Carbon::parse($request->start_date))){
					
					$dates = array_add($dates,$this->counter,$carb->toDateString());
				
					$data = array_add($data,$this->counter,$arr);
				}else{	
				}
				$this->counter += 1;
			}
			if(count($dates)<=0){
				return view('admin/busy-days')->with(['header'=>$this->header]);
				dd('Числа не входят в промежуток');
			}
			
		}else{
			foreach($transactions as $transaction){
				$arr = $transaction->toArray();
				global $dates, $data;
				$carb = Carbon::parse($arr['created_at']);
					
				$dates = array_add($dates,$this->counter,$carb->toDateString());
				
				$data = array_add($data,$this->counter,$arr);
				
				$this->counter += 1;
			}
		}		
		$dates = array_unique($dates);
		
		$endmassive = array();
		$transCount = 0;
		
		foreach($dates as $date){
			global $transCount, $endmassive;
			$transCount = 0;
			foreach($data as $key => &$item){
				if(Carbon::parse($item['created_at'])->toDateString()==$date){
					//dump($item['created_at']);
					unset($data[$key]);
					$transCount++;
				}
			}
			$endmassive[] = $this->createArray($date,$transCount);
		}
			
		return view('admin/busy-days')->with(['datas'=>$endmassive, 'header'=>$this->header]);
		
	}
	
	function createArray($date,$transCount){
		$arr['created_at'] = $date;
		$arr['count'] = $transCount;
		return $arr;
	}
	
	public function busyHours(Request $request){
		$this->header = "Busy Hours";
		
		$transactions = Transaction::select(['amount','created_at'])->get();
		
		$multiplied = $transactions->map(function ($item, $key) {
			$created_atTS = array_get($item->toArray(),'created_at');
			$dt = Carbon::parse($created_atTS);
			$hour = $dt->hour+1;
			$item->created_at = $dt->format('Y-m-d '.$hour.':00:00');
			return $key;
		});
		
		//Перенос модели Транзакции в массив
		$data = array();
		$this->counter = 0;
		
		//Уникальные даты
		$dates = array();
		
		//По дате
		if($request->start_date && $request->end_date){
			$start_date = $request->start_date;
			$end_date = $request->end_date;

			//Выбрано конкретное число
			if($start_date==$end_date){
				
				foreach($transactions as $transaction){
					$arr = $transaction->toArray();
					global $dates, $data;
					$carb = Carbon::parse($arr['created_at']);
					
					//dd($carb->format("Y-m-d H:00:00"));
					
					$dates = array_add($dates,$this->counter,$carb->format("Y-m-d H"));
					
					$data = array_add($data,$this->counter,$arr);
					
					$this->counter += 1;
				}
				
			//Выбра промежуток времени более суток
			}else{
				
			}
		
		//Запрос без времени
		}else{
			
			foreach($transactions as $transaction){
				$arr = $transaction->toArray();
				global $dates, $data;
				$carb = Carbon::parse($arr['created_at']);
				
				//dd($carb->format("Y-m-d H:00:00"));
				
				$dates = array_add($dates,$this->counter,$carb->format("Y-m-d H"));
				
				$data = array_add($data,$this->counter,$arr);
				
				$this->counter += 1;
			}
			
			
		}
		$dates = array_unique($dates);
		
		$endmassive = array();
		$transCount = 0;
		
		
		foreach($dates as $date){
			global $transCount, $endmassive;
			$transCount = 0;
			foreach($data as $key => &$item){
				if(Carbon::parse($item['created_at'])->format("Y-m-d H")==$date){
					//dump($item['created_at']);
					unset($data[$key]);
					$transCount++;
				}
			}
			$endmassive[] = $this->createArray($date,$transCount);
		}
		
		return view('admin/busy-hours')->with(['datas'=>$endmassive,'header'=>$this->header]);
	}
	
	public function addRevenue(Request $request){
		
		$this->validate($request,[
			'amount'=>'required',
			'type'=>'required',
			'user_id'=>'required'
		]);
		
		$data = $request->all();
		
		$data = array_add($data, 'ip', $request->ip());
		
		$transaction = new Transaction;
		
		$transaction->fill($data);
		
		$transaction->save();
		
		return redirect('home');
		
	}
	
	public function edit(Request $request){
		
		$this->validate($request,[
			'id'=>'required',
			'amount'=>'required',
			'user_id'=>'required',
		]);
		
		$transaction = Transaction::where('id',$request->id)->first();
		
		$transaction->forceFill([
			'amount'=>$request->amount,
			'user_id'=>$request->user_id,
		])->save();
		
		return redirect()->route('allTransList');
	}
	
	
	
	
}
