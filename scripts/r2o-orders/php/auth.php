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

/**
 * Check if the access is valid.
 * @return bool
 */
function is_logged_in(): bool
{
    /* Get client */
    $client = update_and_get_client();
    if ($client === false) {
        return false;
    }

    try {
        /* Get throws an exception if the access is invalid */
        $client->get('company');
        return true;
    } catch (Exception) {
        return false;
    }
}

/**
 * Get accountToken from cache, SESSION or param and update it respectively.
 * @param string|false|null $account_token
 * @return string|false
 */
function update_and_get_account_token(string|null|false $account_token = null): string|false
{
    /* Get accountToken from cache */
    if ($account_token === null || $account_token === false) {
        $account_token = @file_get_contents('cache/accountToken.txt');
    }

    /* Get accountToken from SESSION */
    if ($account_token === false && isset($_SESSION['accountToken'])) {
        $account_token = $_SESSION['accountToken'];
    }

    if ($account_token !== false && $account_token !== null) {
        /* Update cache and SESSION */
        $_SESSION['accountToken'] = $account_token;
        safe_to_file('cache/accountToken.txt', $account_token);
        return $account_token;
    }

    return false;
}