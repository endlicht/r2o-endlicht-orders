<?php
declare(strict_types=1);

/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

use ready2order\Client;

$config = parse_ini_file('etc/config.ini');

/**
 * Authenticate at the ready2order API as a developer with a DEVELOPER TOKEN.
 *
 * @param string $dev_token
 * @param string $callback_uri
 *
 * @return mixed
 * @throws JsonException
 */
function auth_as_developer(string $dev_token, string $callback_uri = 'http://localhost:8000/granted'): mixed
{
    /* Authorization URI */
    $url = 'https://api.ready2order.com/v1/developerToken/grantAccessToken';
    $curl = curl_init($url);

    /* Configure curl */
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $dev_token,
        'Accept: application/json',
        'Content-Type: application/json'
    ]);
    curl_setopt($curl, CURLOPT_POST, TRUE);

    /* Specify callback uri after authorization */
    $auth_callback_uri = json_encode(['authorizationCallbackUri' => $callback_uri], JSON_THROW_ON_ERROR);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $auth_callback_uri);

    $response = curl_exec($curl);
    if ($response === FALSE) {
        return FALSE;
    }

    /* Close curl resource, and free up system resources */
    curl_close($curl);

    /* Decode JSON response */
    return json_decode($response, TRUE, 512, JSON_THROW_ON_ERROR);
}

/**
 * Test Client.
 *
 * @param Client $client
 *
 * @return bool
 */
function _try_client(Client $client): bool
{
    try {
        /* Get throws an exception if the access is invalid */
        $client->get('company');
        return TRUE;
    } catch (Exception) {
        return FALSE;
    }
}

/**
 * Check if the access is valid.
 *
 * @return Client|false
 */
function get_client_if_logged_in(): Client|false
{
    /* Get Client from SESSION */
    if (isset($_SESSION['client'])) {
        $client = $_SESSION['client'];

        /* Check if client is valid */
        if ($client && _try_client($client)) {
            return $client;
        }
    }

    $accountToken = get_set_acc_tok();
    if ($accountToken !== FALSE) {
        $client = new Client($accountToken);
        if (_try_client($client)) {
            $_SESSION['client'] = $client;
            return $client;
        }
    }

    return FALSE;
}


/**
 * Get accountToken from cache, SESSION or param and update it respectively.
 *
 * @param string|false|null $account_token
 *
 * @return string|false
 */
function get_set_acc_tok(string|null|false $account_token = NULL): string|false
{
    global $config;
    /* Get accountToken from cache */
    if (($account_token === NULL || $account_token === FALSE) && $config !== FALSE && $config['cacheAccountToken'] === '1') {
        $account_token = @file_get_contents('cache/accountToken.priv');
    }

    /* Get accountToken from SESSION */
    if (isset($_SESSION['accountToken']) && ($account_token === NULL || $account_token === FALSE)) {
        $account_token = (string)$_SESSION['accountToken'];
    }

    if ($account_token !== FALSE && $account_token !== NULL) {
        /* Update cache and SESSION */
        $_SESSION['accountToken'] = $account_token;
        if ($config['cacheAccountToken'] === '1') {
            safe_to_file('cache/', 'accountToken.priv', $account_token);
        }
        return $account_token;
    }

    return FALSE;
}