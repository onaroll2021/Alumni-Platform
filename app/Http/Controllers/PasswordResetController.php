<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Hash;
use Input;
use Cookie;
use Mail;
use Session;
use Validator;
use App\Classes\Common;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasswordResetController extends Controller
{
    /**
     * Create a new sessions controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showReset(Request $request, $token) {
        date_default_timezone_set('America/Los_Angeles');
        $datetime = date('Y-m-d H:i:s');

        $query = DB::table('password_resets')
        ->where('deleted', 0)
        ->where('token', $token)
        ->where('isValid', 1)
        ->first(array('created_at'));

        if ($query == null) {
            return view('auth.reset', ['invalid' => true]);
        }
        //$expireTime = strtotime('+30 minute', strtotime($query->created_at));
        $expireTime = strtotime('+24 hour', strtotime($query->created_at));
        if ($expireTime > time()) {
            return view('auth.reset');
        } else {
            return view('auth.reset', ['invalid' => true]);
        }

    }

    public function doReset(Request $request, $token){
        $validator = Validator::make(request()->all(), [
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {
            DB::table('password_resets')->where('token', $token)->update(array('deleted' => 1));
            $email = DB::table('password_resets')->where('token', $token)->where('isValid', 1)->first(array('email'));
            DB::table('users')
            ->where('email', $email->email)
            ->update(array('password' => Hash::make(request()->input()['password'])));

            return redirect('login')->with('passwordReset', true);
        }
    }

    public function showEmail(Request $request) {
        return view('auth.password');
    }

    public function doEmail(Request $request) {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {
            $email = $request->input()['email'];
            if (DB::table('users')->where('active', 1)->where('email', $email)->count() != 1) {
                return redirect('/login/reset')->with('error', true);
            }

            $token = Common::generateHash(128);

            date_default_timezone_set('America/Los_Angeles');
            $datetime = date('Y-m-d H:i:s');

            DB::table('password_resets')->insert(array('email' => $email, 'token' => $token, 'created_at' => $datetime, 'isValid' => 1));

            Mail::send('emails.password', ['token' => $token], function ($m) use ($token, $email) {
				$m->getSwiftMessage()->getHeaders()->addTextHeader('X-SMTPAPI', json_encode(
					array(
						"unique_args" => array(
							'email_type' => "PASSWORD_RESET",
						),
					)
				));

                // If email is requested from any other environment other than production, the configuration set
                // will not be included so a push won't happen in the dev/local server
                if(env('APP_ENV') == 'production') {
                    $m->getSwiftMessage()->getHeaders()->addTextHeader('X-SES-CONFIGURATION-SET', 'SES_TO_SNS');
                } else {
                    $m->getSwiftMessage()->getHeaders()->addTextHeader('X-SES-CONFIGURATION-SET', 'DEV_SES_TO_SNS');
                }

                $m->to($email)->subject('Terry Fox Humanitarian Award Program - Password Reset');
                $m->from('noreply@terryfoxawards.ca', 'Terry Fox Awards');
                $m->replyTo('info@terryfoxawards.ca');
            });

            return redirect('/login/reset')->with('success', true);
        }
    }

}
