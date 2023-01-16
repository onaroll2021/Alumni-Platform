<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use App\User;
use Auth;
use Input;
use DB;
use Session;
use Mail;
use App\Classes\Common;
use Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Response;
use Log;

use Hash;
use Cookie;



class DashboardController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   	
        return view('dashboard');
    }

    	/**
     * Return alumni profile image.
     */
    public static function getProfileImage(Request $request) {
        $profile = DB::table('users_basic_info')
        ->where('user_id', Auth::User()->id)
        ->first(array('avatar_filename'));
        if ($profile->avatar_filename == null) {
            $path = "http://dev.terryfoxawards.ca/img/profile-placeholder.jpg";
            return Response::make(file_get_contents($path), 200, [
                'Content-Type' => 'image',
            ]);
        } else {
            $path = storage_path().DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$profile->avatar_filename;
            return Response::make(file_get_contents($path), 200, [
                'Content-Type' => 'image',
            ]);

        }

    }
}
