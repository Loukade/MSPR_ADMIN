<?php
namespace mspr\Services\SmsService;
require_once (__DIR__.'/../../../../vendor/autoload.php');

use Twilio\Rest\Client;

class SmsService{
    private const TWILIO_ACCOUNT_SID = "AC5b83545b7d2be1a89b1ae35f5a257436";
    private const TWILIO_AUTH_TOKEN = "f92bdf41be7cd692a8f160daa8b2f48a";


    public static function sendSms(string $phoneNumber){
        $twilio = new Client(self::TWILIO_ACCOUNT_SID, self::TWILIO_AUTH_TOKEN);

        $message = $twilio->messages
            ->create("+33".$phoneNumber, // to
                ["body" => "Votre code de sécurité est : 4532", "from" => "+19377212810"]
            );
    }
}
