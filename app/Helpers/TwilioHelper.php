<?php

namespace App\Helpers;

require_once __DIR__ . '/../vendor/autoload.php';

use Twilio\Rest\Client;

class TwilioHelper
{
    private string $accountSid;
    private string $authToken;
    private string $twilioNumber;
    private string $twilioMessageServiceSid;
    private Client $twilio;

    public function __construct()
    {
        $this->accountSid = env('TWILIO_ACCOUNT_SID');
        $this->authToken = env('TWILIO_AUTH_TOKEN');
        $this->twilioNumber = env('TWILIO_NUMBER');
        $this->twilioMessageServiceSid = env('TWILIO_MESSAGE_SERVICE_SID');
        $this->twilio = new Client($this->accountSid, $this->authToken);
    }

    public function sendSms(string $to, string $message): void
    {
        $message = $this->twilio->messages->create(
            $to,
            [
                'messagingServiceSid' => $this->twilioMessageServiceSid,
                'from' => $this->twilioNumber,
                'body' => $message
            ]
        );
    }
}
