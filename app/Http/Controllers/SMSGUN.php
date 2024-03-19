<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SMSGUN extends Controller
{

    public function sendSMS(Request $request)
    {
        $basic  = "Paster dari grub";
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($request->input('no_telp'), 'Herru We Here You', 'Herru We Here You A text message sent using the SMS, DAFFA SEHAT\n')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }
}
