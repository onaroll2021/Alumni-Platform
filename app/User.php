<?php

namespace App;

use Str;
use Mail;
use Request;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

        /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'type', 'verified', 'active', 'registerIP', 'lastActivity'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'verified_token'];

    /**
     * Boot the model.
     *
     * @return void
     */

     public static function boot(){
        parent::boot();
        static::creating(function ($user) {
            $user->verified_token = Str::random(30);

            $user->registerIP = Request::getClientIp();

            Mail::send('emails.confirm', ['token' => $user->verified_token], function ($m) use ($user) {
				$m->getSwiftMessage()->getHeaders()->addTextHeader('X-SMTPAPI', json_encode(
					array(
						"unique_args" => array(
							'email_type' => "VERIFY_ACCOUNT",
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

                $m->to($user->email)->subject('Terry Fox Humanitarian Award Program - Verify Account');
                $m->from('noreply@terryfoxawards.ca', 'Terry Fox Awards');
                $m->replyTo('info@terryfoxawards.ca');
            });

        });
    }
    /**
     * Verify the user.
     *
     * @return void
     */
    public function verify(){
        if ($this->type == "EVALUATOR") {
            $this->verified = true;
            $this->verified_token = null;
            $this->save();
        } else {
            $this->verified = true;
            $this->verified_token = null;
            $this->active = true;
            $this->save();
        }
    }

}