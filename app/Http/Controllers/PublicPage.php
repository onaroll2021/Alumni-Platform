<?php

namespace App\Http\Controllers;

use App;
use App\User;
use Auth;
use Response;
use DB;
use Session;
use Mail;
use App\Classes\Common;
use App\Classes\Security;
use Config;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PublicPage extends Controller
{
	public static function saveSNSNotification(Request $request) {
		// Parse the request body and decode it to array
		$inputs = json_decode($request->getContent(), true);
        Log::info($request->message);

	}

}
