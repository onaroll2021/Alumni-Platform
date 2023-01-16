<?php 
namespace App\Classes;

use DB;
use Log;
use Config;
use Mail;
use Validator;
use Mailgun\Mailgun;

class Common {

    /*
        Generate a random hash of numbers and capital letters.
    */
    public static function generateHash($length = 8){
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randKey = '';
		for ($i = 0; $i < $length; $i++) {
			//$randKey .= $characters[mt_rand(0, 36)];
			$randKey .= substr($characters, mt_rand(0, 36), 1);
		}
		return $randKey;
	}

}
?>