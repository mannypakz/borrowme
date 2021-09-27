<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmailNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role',
        'name', 
        'email', 
        'password', 
        'provider_id',
        'first_name',
        'last_name',
        'location_code',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'country',
        'neighbourhood',
        'registration_type',
        'company_name',
        'company_web_address',
        'company_logo',
        'login_source',
        'verification_code',
        'profile_image',
        'token',
        'lat',
        'lng',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification() {
        $code = $this->verification_code;
        $token = $this->token;
        $firstname = $this->first_name;
        $this->notify(new VerifyEmailNotification($code, $token, $firstname));
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}
