<?php

namespace App\Listeners;

use Mailgun\Mailgun;

class RequestOTPListener
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
    public function handle(object $event): void
    {
        if (env('APP_ENV') != 'local') {
            $session = $event->session;
            $user = $session->user;

            // TODO : should be added from secret after regenerate
            $mg = Mailgun::create('f412476973e6a7810fda1c56319d7bbe-181449aa-90dda88a', 'https://api.eu.mailgun.net'); // For US servers

            $mg->messages()->send('mg.werify.net', [
                'from' => 'no-reply@werify.net',
                'to' => $user->email,
                'text' => 'Hello '.$user->name.'
You requested an OTP code!
Your OTP code is '.$session->otp.'',
                'subject' => 'here is your OTP',
            ]);
        }
    }
}
