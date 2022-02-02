<?php

function auth_as_developer(string $dev_token, string $callback_uri = 'http://localhost:8000/granted')
{
    /* authorization uri */
    $url = 'https://api.ready2order.com/v1/developerToken/grantAccessToken';
    $curl = curl_init($url);

    /* configure curl */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $dev_token,
        'Accept: application/json',
        'Content-Type: application/json'
    ));
    curl_setopt($curl, CURLOPT_POST, true);
    
    /* specify callback uri after authorization */
    $auth_callback_uri = json_encode(array('authorizationCallbackUri' => $callback_uri));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $auth_callback_uri);

    $response = curl_exec($curl);

    /* close cURL resource, and free up system resources */
    curl_close($curl);

    /* decode json response */
    $response = json_decode($response, true);
    return $response;
}
