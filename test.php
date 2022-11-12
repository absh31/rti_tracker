<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.d7networks.com/messages/v1/send',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "messages": [
    {
        "channel": "sms",
        "recipients": ["+919510997150"],
        "content": "Greetings from D7 API",
        "msg_type": "text",
        "data_coding": "text"
    }
  ],
  "message_globals": {
    "originator": "SignOTP",
    "report_url": "https://the_url_to_recieve_delivery_report.com"
  }
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJhdXRoLWJhY2tlbmQ6YXBwIiwic3ViIjoiM2EzZTZkNWEtNDMwYi00ZmZmLWFmY2EtZjJlMGU5MjY0YzdhIn0.1zm72taaaMrnmBgwWBjCUTQQH500SesoeQoyZLH-cOw'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;