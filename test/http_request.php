<?php

// $blogID = '8070105920543249955';
// $authToken = 'OAuth 2.0 token here';

// The data to send to the API
$postData = array(
    'Keyword' => 'asus go',
    'Size' => '5'
);

// Setup cURL
$ch = curl_init('http://localhost:1989/api/search/list');
curl_setopt_array($ch, array(
    CURLOPT_POST => TRUE,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_HTTPHEADER => array(
        // 'Authorization: '.$authToken,
        'Content-Type: application/json'
    ),
    CURLOPT_POSTFIELDS => json_encode($postData)
));

// Send the request
$response = curl_exec($ch);
echo $response;

// Check for errors
if($response === FALSE){
	echo "crot";
    die(curl_error($ch));
}

// Decode the response
$responseData = json_decode($response, TRUE);

// Print the date from the response
// echo $responseData['published'];
?>