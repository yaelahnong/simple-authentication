<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTFACode implements ShouldQueue
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
      $client = new \GuzzleHttp\Client(['verify' => 'E:\wamp64\bin\php\php7.4.9\extras\ssl\cacert.pem']);
      $client->request('POST', "https://rest.nexmo.com/sms/json", [
        'form_params' => [
          'from' => 'Vonage APIs',
          'text' => 'Simple Authentication App'. $this->data['tfaCode'] . ' is your 2FA Code',
          'to' => $this->data['phone'],
          'api_key' => '642a1356',
          'api_secret' => 'U21LifBFPrCH7hQZ'
        ]
      ]);
    }
}
