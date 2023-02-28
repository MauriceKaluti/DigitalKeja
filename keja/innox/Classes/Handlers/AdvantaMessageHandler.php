<?php


namespace Innox\Classes\Handlers;


use Innox\Contracts\ShouldSendNotification;

class AdvantaMessageHandler implements ShouldSendNotification
{

    public function send($to, $message)
    {
        $apiKey = setting('advanta_api_key');
        $partnerId = setting('advanta_partner_id');
        $senderShortCode = setting('advanta_short_code');

        $url = 'https://quicksms.advantasms.com/api/services/sendsms/';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json')); //setting custom header


        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'partnerID' => $partnerId,
            'apikey' => $apiKey,
            'mobile' => $to,
            'message' => $message,
            'shortcode' => $senderShortCode,
            'pass_type' => 'plain', //bm5 {base64 encode} or plain
            "timeToSend" => now()->addRealSeconds(10)->format('Y-m-d H:i')
        );

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

       return curl_exec($curl);
    }
}
