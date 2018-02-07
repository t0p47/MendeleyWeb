<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Auth;
use App\AdminUser;
use App\User;
use Response;
use Dingo\Api\Routing\Helpers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
	
	use AuthenticatesUsers, Helpers;
	
	/**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('guest', ['except' => 'logout']);
//    }

    public function authenticate(Request $request){
        $credentials = $request->only('email','password');

        try{
            if(! $token=JWTAuth::attempt($credentials)){
                //return Response::errorUnauthorized();
                return $this->response->errorUnauthorized();
            }
        }catch(JWTException $ex){
            return Response::errorInternal;
            //return $this->response->errorInternal;
        }


        $user_id = Auth::user()->id;

        //return Response::array(compact('token'))->setStatusCode(200);
        return  $this->response->array(compact('token','user_id'))->setStatusCode(200);
    }

    //Get all users
    public function index(){
        return User::all();
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

    public function getToken(){

        $token = JWTAuth::getToken();

        //return response()->json(compact('token'));

        if (! $token) {
            throw new BadRequestHttpException('Token not provided');
        }

        try {
            $token = JWTAuth::refresh($token);
        } catch (TokenInvalidException $e) {
            throw new AccessDeniedHttpException('The token is invalid');
        }

        return response()->json(compact('token'));


        /*$token = JWTAuth::getToken();

        if(!$token){
            return Response::errorUnauthorized("Token is invalid");
        }

        try{
            $refreshedToken = JWTAuth::refresh();
        }catch(JWTException $ex){
            return Response::error("Something went wrong!");
        }

        return $this->response->array(compact('refreshedToken'))->setStatusCode(200);*/
    }
	
	/**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
	
	/**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
		$email = $request->email;
		$password = $request->password;
		$ip = $request->ip();
		if(!$this->checkEmailConfirmed($email)){
			return 'not confirmed';
		}
		
		$admin = AdminUser::select('ip','ip_restrict')->first();
		
		if($admin->ip_restrict=="yes"){
			if($admin->ip!=$ip){
				dd('Incorrect ip address');
			}else{
				if(Auth::attempt(['email' => $email,'password'=>$password])){
					//Если ip_restict=true и он совпадает
					dd('LoginController yes1');
				}
			}
		}
				
		if(!Auth::attempt(['email' => $email,'password'=>$password])){
			//Неверные логин или пароль
			return false;
		//Данные верны
		}else{
			//либо ip_restrict - no, либо ip не совпал
			if(Auth::attempt(['email' => $email, 'password' => $password, 'ip_restrict' => 'yes','ip'=>$ip])){
				//dd('all correct');
				//ip_restrict=true и ip адрес совпал
				dd('LoginController yes2');
			}else{
				//Учитывая что данные верны если это условие не выполняется, то ip_restrict - yes, исходя из условия выше считаем что неверен ip адрес
				if(Auth::attempt(['email' => $email, 'password' => $password, 'ip_restrict' => 'no'])){
					//dd('no ip_restrict');
					return 'login';
				}else{
					die('incorrect ip');
				}
			}
		}
    }

    protected function checkEmailConfirmed($email){
    	$user = User::where('email', $email)->first();
    	if($user->confirmed==1){
    		return true;
    	}else{
    		return false;
    	}
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)=='login') {
            return $this->sendLoginResponse($request);
        }

        if ($this->attemptLogin($request)=='not confirmed') {
            return redirect(route('login'))->with('status', 'You did not confirmed your email address.');
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

	/**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }
    
	/**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {		
		//dump('logout');
	
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/login');
    }

    

    
}
