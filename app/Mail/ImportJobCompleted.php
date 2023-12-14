<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ImportJobCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $filename;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    public function build()
    {
        return $this->view('emails.import-job-completed')
            ->with(['filename' => $this->filename])
            ->subject('Import Job Completed');
    }
}
