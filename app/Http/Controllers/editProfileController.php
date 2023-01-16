<?php

namespace App\Http\Controllers;

use App;
use App\User;
use Auth;
use DB;
use Session;
use Mail;
use App\Classes\Common;
use Config;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Response;
use Storage;
use Log;

class editProfileController extends Controller
{

/**
     * Upload profile picture as alumni.
     */
    public static function uploadProfile(Request $request) {
        
        if ($request->hasFile('file')) {
            if ($request->file('file')->isValid()){
                if (in_array($request->file('file')->getMimeType(), array('image/png', 'image/jpeg', 'image/jpg'))) {
                    if ($request->file('file')->getSize() <= 2097152) { // Only allow files under 2 MB.
                        $curr_profile_name = DB::table('users_basic_info')
                        ->where('user_id', Auth::User()->id)
                        ->first(array('avatar_filename'));
                        if (!is_null($curr_profile_name->avatar_filename)) {
                            unlink(storage_path() . '/uploads/' . $curr_profile_name->avatar_filename);
                        }
                        
                        $mimeType = $request->file('file')->getMimeType();
                        $clientName = $request->file('file')->getClientOriginalName();
                        $clientSize = $request->file('file')->getSize();
                        $fileExtension = $request->file('file')->guessExtension();
                        $newName = 'ALUMNI_'.Auth::User()->id.'_'.Common::generateHash(8).'.'.$fileExtension;

                        $request->file('file')->move(storage_path() . '/uploads/', $newName);

                        DB::table('users_basic_info')
                        ->where('user_id', Auth::User()->id)
                        ->update(array('avatar_filename' => $newName));

                        return response('updated', 200);
                    } else {
                        return response('too_large', 422);
                    }
                } else {
                    return response('invalid', 422);
                }
            } else {
                return response('not_valid', 422);
            }
        } else {
            return response('no_file', 422);
        }

    }

    	/**
     * Handle post request of updating info.
     */
    public static function updateInfo(Request $request) {

        //Fields validation first
		$validator = Validator::make($request->all(), [
            'name_first' => 'required|alpha',
            'name_last' => "required|alpha",

            'primary_address_city' => 'nullable|alpha',
            'primary_address_country' => 'nullable|alpha',
            'shipping_address_city' => 'nullable|alpha',
            'shipping_address_country' => 'nullable|alpha',

            'personal_website' => 'nullable|url',
            'contact_facebook' => 'nullable|url',
            'contact_twitter' => 'nullable|url',
            'contact_linkedin' => 'nullable|url',
            'contact_instagram' => 'nullable|url',
            'link_of_interest_1' => 'nullable|url',
            'link_of_interest_2' => 'nullable|url',
            'link_of_interest_3' => 'nullable|url',

            'primary_phone_area' => 'nullable|numeric|digits:3|required_with:primary_phone_number',
            'primary_phone_number' => 'nullable|required_with:primary_phone_area',
            'mobile_phone_area' => 'nullable|numeric|digits:3|required_with:mobile_phone_number',
            'mobile_phone_number' => 'nullable|required_with:mobile_phone_area',
            'work_phone_area' => 'nullable|numeric|digits:3|required_with:work_phone_number',
            'work_phone_number' => 'nullable|required_with:work_phone_area',
            'other_phone_area' => 'nullable|numeric|digits:3|required_with:other_phone_number',
            'other_phone_number' => 'nullable|required_with:other_phone_area',

            'primary_email' => 'nullable|email',
            'alternative_email' => 'nullable|email',
            'work_email' => 'nullable|email',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

		$update = array(
            'name_first' => $request->name_first,
            'name_last' => $request->name_last,
            'location' => $request->location,
            'TFHA_alumni_year' => $request->TFHA_alumni_year,
            'university_name' => $request->university_name,
            'diploma' => $request->diploma,
            'short_bio' => $request->short_bio,
            'place_of_birth' => $request->place_of_birth,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'profession' => $request->profession,
            'ethnicity' => $request->ethnicity,
            'indigenous_identity' => $request->indigenous_identity,
            'visible_minority' => $request->visible_minority,
            'languages' => $request->languages,
            'TFHA_years_in_program' => $request->TFHA_years_in_program,
            'total_scholarship_funds' => $request->total_scholarship_funds,
            'primary_address_address' => $request->primary_address_address,
            'primary_address_address_2' => $request->primary_address_address_2,
            'primary_address_city' => $request->primary_address_city,
            'primary_address_province' => $request->primary_address_province,
            'primary_address_postal' => $request->primary_address_postal,
            'primary_address_country' => $request->primary_address_country,
            'shipping_address_address' => $request->shipping_address_address,
            'shipping_address_address_2' => $request->shipping_address_address_2,
            'shipping_address_city' => $request->shipping_address_city,
            'shipping_address_province' => $request->shipping_address_province,
            'shipping_address_postal' => $request->shipping_address_postal,
            'shipping_address_country' => $request->shipping_address_country,
            'primary_phone_area' => $request->primary_phone_area,
            'primary_phone_number' => $request->primary_phone_number,
            'mobile_phone_area' => $request->mobile_phone_area,
            'mobile_phone_number' => $request->mobile_phone_number,
            'work_phone_area' => $request->work_phone_area,
            'work_phone_number' => $request->work_phone_number,
            'other_phone_area' => $request->other_phone_area,
            'other_phone_number' => $request->other_phone_number,
            'primary_email' => $request->primary_email, 
            'alternative_email' => $request->alternative_email, 
            'work_email' => $request->work_email, 
            'contact_instagram' => $request->contact_instagram,
            'contact_facebook' => $request->contact_facebook,
            'contact_twitter' => $request->contact_twitter, 
            'contact_linkedin' => $request->contact_linkedin, 
            'personal_website' => $request->personal_website, 
            'link_of_interest_1' => $request->link_of_interest_1, 
            'link_of_interest_2' => $request->link_of_interest_2,
            'link_of_interest_3' => $request->link_of_interest_3,
            'pronouns' => $request->pronouns,
            'lastSaved_timestamp' => date('Y-m-d H:m:s', time()),
		);


		DB::table('users_basic_info')
		->where('user_id', Auth::User()->id)
		->update($update);

		return redirect('/dashboard')->with('success', trans('common.information_updated'));

    }

}

