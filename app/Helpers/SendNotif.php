<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class SendNotif{

    public function sendMessage(Request $requets)
    {
        $content = array(
            "en" => $requets->content,
        );

        $fields = array(
            'app_id' => "787d6428-2b70-463d-a858-eec955e1a922",
            'include_player_ids' => explode(',',$requets->id),
            'large_icon' => '@drawable/msilogo',
            'small_icon' => '@drawable/msilogo',
            'contents' => $content
        );

        $fields = json_encode($fields);
        // print("\nJSON sent:\n");
        // print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        curl_exec($ch);
        curl_close($ch);

        // return $response;
    }
}
