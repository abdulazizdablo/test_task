<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function products()
    {

        return $this->hasMany(Product::class);
    }

    public function fullName()
    {

        return $this->first_name . ' ' . $this->last_name;
    }



    public function markEmailAsVerified()
    {

        $this->activation_code = null;
        $this->email_verified_at = Carbon::now();
        $this->save();
    }


    public function sendEmailVerificationNotification()
    {
        // Generate a verification code.
        $code = random_int(1000, 9999);

        // Send the verification code to the user's email address.
        Mail::raw("Hi, welcome user! Please confirm this code $code ", function ($message) {
            $message->to('abooddablo@gmail.com')
                ->subject("Verify your code");
        });

        $this->activation_code = $code;
        $this->save();
    }
}
