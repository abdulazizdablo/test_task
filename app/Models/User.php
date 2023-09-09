<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Mail;
use App\Services\ActivationCodeService;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;


public function __construct(private ActivationCodeService $code_service)
{
    
}

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
    public function products():HasMany
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
        $this->email_verified_at = now();
        $this->save();
    }


    public function sendEmailVerificationNotification( )
    {
        // Generate a verification code.
   $code = $this->code_service->generateActivationCode();
        // Send the verification code to the user's email address.
        Mail::raw("Hi, welcome user! Please confirm this code $code ", function ($message) {
            $message->to($this->email)
                ->subject("Verify your code");
        });

        $this->activation_code = $code;
        $this->save();
    }
}
