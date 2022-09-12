<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
class FirebaseController extends Controller
{
    public function index(){

//        $serviceAccount = ServiceAccount::fromJsonFile(base_path('/warehouse-management-19424-firebase-adminsdk-9pyb4-3855cade95.json'));
//        $firebase = (new Factory)
//            ->withServiceAccount($serviceAccount)
//            ->withDatabaseUri('https://warehouse-management-19424.firebaseio.com/')
//            ->create();
//
//        $database = $firebase->getDatabase();
//
//        $newPost = $database
//            ->getReference('/invoice_product_variation/3')
//            ->update([
//
//                 'name' => 'Laravel FireBase Tutorial updated now'
//
//            ]);
//        echo '<pre>';
//        print_r($newPost->getvalue());

        $googleServerKey = "AAAAyCY6sGI:APA91bGm-eO1neqLKSXckdneF9auIgR1s9v2QrOjbyfuuIGlWIB1luRLywRCazNniDrD2aFm87qazRVAn771d8lvT1Qo_ij4HsbZv6I3gjhCcyw4B8tqlg5lv8ZveQ5ZR1UCBrsiRdYi";

        //Sets the serverKey variable to the googleServerKey variable in the serverKeyInfo.php script.
        $serverKey = $googleServerKey;

        //URL that we will send our message to for it to be processed by Firebase.
        $url = "https://fcm.googleapis.com/fcm/send";

        //Recipient of the message. This can be a device token (to send to an individual device)
        //or a topic (to be sent to all devices subscribed to the specified topic).
        $recipient = "/topics/all";

        //Structure of our notification that will be displayed on the user's screen if the app is in the background.
        $notification =
            [
                'title'   => "4th of July Sale!",
                'body'   => "All skins half off until",
                'sound'	=>	"default"
            ];

        //Structure of the data that will be sent with the message but not visible to the user.
        //We can however use Unity to access this data.
        $dataPayload =
            [
                "powerLevel" => "9001",
                "dataString" => "This is some string data"
            ];

        //Full structure of message inculding target device(s), notification, and data.
        $fields =
            [
                'to'  => $recipient,
                'notification' => $notification,
                'data' => $dataPayload
            ];

        //Set the appropriate headers
        $headers =
            [
                'Authorization: key=' . $serverKey,
                'Content-Type: application/json'
            ];

        //Send the message using cURL.
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, $url);
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );

        //Result is printed to screen.
        echo $result;
    }
}
