<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailFP implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
      $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

      $opt = [
        "name" => "Marino Imola",
        "email" => $this->data['email'],
        "url" => "http://localhost:8080/reset-password?token=" . $this->data['token']
      ];

      Mail::send('email.mail', $opt, function ($message) {
        $message->to($this->data['email'])
                ->subject('Account Reset Password')
                ->from('noreply@simpleauth.com', 'Simple Authentication');
      });
    }
}
