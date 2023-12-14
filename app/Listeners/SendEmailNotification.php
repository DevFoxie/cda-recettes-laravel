<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\ImportRecipesJobCompleted;
use Illuminate\Mail\Mailer;

class SendEmailNotification implements ShouldQueue
{
    public function handle(ImportRecipesJobCompleted $event)
    {


        $adminEmail = 'hakim@garage404.com';
        \Mail::to($adminEmail)->send(new \App\Mail\ImportJobCompleted($event->filename));

        dd('Email sent successfully!');
    }
}
