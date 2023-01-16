<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Log;

// copy use models from OAS
use Auth;
use DB;
use Input;
use Cookie;
use Config;
use Session;
use App\Http\Controllers\Controller;

/* perform the login
* @param Request $request
* @return \redirect
*/

class LoginController extends Controller
{
    protected function signIn(Request $request){
        //Attempt login to check credentials.
        $attempt = Auth::attempt($this->getCredentials($request), $request->has('remember'));
        if ($attempt == true){
            // Correct login, check for verifed status.
            if (DB::table('users')->where('email', $request->input('email'))->where('verified', true)->count() != 1) {
                Auth::logout();
                return 'verification_failed';
            } else {
                if (DB::table('users')->where('email', $request->input('email'))->where('active', true)->count() != 1) {
                    Auth::logout();
                    return 'active_failed';
                } else {
                    return 'success';
                    }
                }
            } else {
            return 'failed';
        }
    }

    /**
     * Get the login credentials and requirements.
     *
     * @param  Request $request
     * @return array
     */
    protected function getCredentials(Request $request){
        return [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ];
    }

    public function doLogin(Request $request)
    {
        $this->validate($request, ['email' => 'required|email', 'password' => 'required']);

        switch ($this->signIn($request)){
            case 'success':
                return redirect()->intended('/dashboard');
            break;
            case 'failed':
                $request->session()->flash('error', 'incorrect');
                return redirect()->back()->withInput($request->except('password'));
            break;
            case 'verification_failed':
                $request->session()->flash('error', 'verify');
                return redirect()->back()->withInput($request->except('password'));
            break;
            case 'active_failed':
                $request->session()->flash('error', 'active');
                return redirect()->back()->withInput($request->except('password'));
            break;
            default:
                $request->session()->flash('error', 'unknown');
                return redirect()->back()->withInput($request->except('password'));
            break;
        }
    }

        /**
     * Destroy the user's current session.
     *
     * @return \Redirect
     */
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
};


