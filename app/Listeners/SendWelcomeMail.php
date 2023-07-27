<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailActivationCode;
use CodeGeneratorService;

class SendWelcomeMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event, CodeGeneratorService $code)
    {
       // Mail::to('aboodablo@gmail.com')->send(new EmailActivationCode());


      

       Mail::raw("Hi, welcome user! Please confirm this code $code ", function ($message) {
        $message->to('abooddablo@gmail.com')
          ->subject("ggll");
      });


 
    }
}
