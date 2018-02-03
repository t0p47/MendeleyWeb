<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user/home');
    }

    public function downloadWindows(){

        //return response()->file(storage_path("app/public/19/guice.pdf"));
        return response()->download(storage_path("app/public/MendeleySetup.msi"));

    }

    public function phpinfo(){

        phpinfo();

    }
}
