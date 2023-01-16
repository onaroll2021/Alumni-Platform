<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Log;
use DB;
use Auth;
use Cookie;
use Config;
use Session;
use App\Classes\Common;
use App\User;
use App\Http\Controllers\Controller;

class RegisterController extends Controller

{
    /**
     * Confirm a user's email address.
     *
     * @param  string $token
     * @return mixed
     */
    public function confirmEmail($token){
        User::where('verified_token', $token)->firstOrFail()->verify();
        return redirect('login')->with('success', 'verified');
    }

    public function doRegister(Request $request){
        $this->validate($request, [
            'email' => 'required|email|max:255|unique:users|confirmed',
            'password' => 'required|confirmed|min:6',
        ]);

        /* 
           Create new user in users table
        */
        $user = User::create([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'type' => 'ALUMNI',
            'lastActivity' => date('Y-m-d H:i:s'),
            'registerIP' => $request->getClientIP(),
        ]);

        if ($request->has('marketing')) {
			if ($request->marketing == 'yes') {
				//Update marketing preferences
				DB::table('users')->where('email', $request->email)->update(array('marketing' => 1));
			}
		};

        /* 
           Create new user_basic_info in users_basic_info table
        */
        $users_basic_info_id = DB::table('users_basic_info') 
        ->insertGetId([
            'user_id' => $user->id,
            // 'name_prefix' => 'big',
            // 'name_first' => 'miss',
            // 'name_last' => 'fortune',
            // 'location' => 'Vancouver, BC',
            // 'TFHA_alumni_year' => 1982,
            // 'university_name' => 'Simon Fraser Valley',
            // 'diploma' => 'Computer Science',
            // 'short_bio' =>'This is a short bio about who I am and what I am passionate about.This is a short bio about who I am and what I am passionate about.This is a short bio about who I am and what I am passionate about.',
            // 'place_of_birth' => 'White Rock, BC',
            // 'birthday' => '1984-08-18',
            // 'gender' => 'Female',
            // 'profession' => 'Business Development Specialist',
            // 'ethnicity' => 'Aboriginal, Irish, Canadian',
            // 'indigenous_identity' => 'Qaipu Mikmaq',
            // 'visible_minority' => 'N/A',
            // 'languages' => 'English',
            // 'TFHA_years_in_program' => '2003-2006',
            // 'total_scholarship_funds' => '$21,000',
            // 'primary_address_address' => '15231 20 Avenue',
            // 'primary_address_address_2' => null,
            // 'primary_address_city' => 'Surrey',
            // 'primary_address_province' => 'British Columnbia',
            // 'primary_address_postal' => 'V4A 2A2',
            // 'primary_address_country' => 'Canada',
            // 'shipping_address_address' => '15231 20 Avenue',
            // 'shipping_address_address_2' => null,
            // 'shipping_address_city' => 'Surrey',
            // 'shipping_address_province' => 'British Columbia',
            // 'shipping_address_postal' => 'V4A 2A2',
            // 'shipping_address_country' => 'Canada',
            // 'primary_phone_area' => '604',
            // 'primary_phone_number' => '345-6754',
            // 'mobile_phone_area' => '604',
            // 'mobile_phone_number' => '345-5754',
            // 'work_phone_area' => '604',
            // 'work_phone_number' => '345-5756',
            // 'other_phone_area' => '604',
            // 'other_phone_number' => '345-9878',
            // 'primary_email' => 'luke@gmail.com',
            // 'alternative_email' => 'luke@gmail.com',
            // 'work_email' => 'luke@gmail.com',
            // 'contact_instagram' => 'http://www.facebook.com/luke.li.9275/',
            // 'contact_facebook' => 'http://www.facebook.com/luke.li.9275/',
            // 'contact_twitter' => 'http://www.facebook.com/luke.li.9275/',
            // 'contact_linkedin' => 'http://www.facebook.com/luke.li.9275/',
            // 'personal_website' => 'www.lukeli.ca',
            // 'link_of_interest_1' => 'www.interestOne.ca',
            // 'link_of_interest_2' => 'www.interestTwo.ca',
            // 'link_of_interest_3' => 'www.interestThree.ca',
            // 'pronouns' => 'he/she',
        ]);

        return redirect('login')->with('info', 'verify'); //redirect with flashed session data, to retrieve, use {{session('status)}} in html or $request->session()->all();
    }
}

