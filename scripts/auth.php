<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

/**
 * Authenticate at the ready2order API as a developer with a DEVELOPER TOKEN.
 * @param string $dev_token
 * @param string $callback_uri
 * @return mixed
 * @throws JsonException
 * @noinspection PhpMultipleClassDeclarationsInspection
 */
function auth_as_developer(string $dev_token, string $callback_uri = 'http://localhost:8000/granted'): mixed
{
    /* Authorization URI */
    $url = 'https://api.ready2order.com/v1/developerToken/grantAccessToken';
    $curl = curl_init($url);

    /* Configure curl */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $dev_token,
        'Accept: application/json',
        'Content-Type: application/json'
    ));
    curl_setopt($curl, CURLOPT_POST, true);

    /* Specify callback uri after authorization */
    $auth_callback_uri = json_encode(array('authorizationCallbackUri' => $callback_uri), JSON_THROW_ON_ERROR);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $auth_callback_uri);

    $response = curl_exec($curl);

    /* Close curl resource, and free up system resources */
    curl_close($curl);

    /* Decode JSON response */
    return json_decode($response, true, 512, JSON_THROW_ON_ERROR);
}
