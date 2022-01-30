<?php

require __DIR__ . '/vendor/autoload.php';

include("auth.php");
include("helpers.php");

use \ready2order\Client;

/* Used to load private key from .env file */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

session_start();

$URL = $_SERVER['REQUEST_URI'];

if (parse_url($URL, PHP_URL_PATH) === '/auth') {
    $grantAccessResponse = auth_as_developer($_ENV['DEVELOPER_TOKEN'], 'http://' . $_SERVER['HTTP_HOST'] . '/granted');
    $_SESSION['grantAccessToken'] = $grantAccessResponse['grantAccessToken'];
    /* Redirect to ready2order authorization page */
    header('Location: ' . $grantAccessResponse['grantAccessUri'], true, 301);
} else if (parse_url($URL, PHP_URL_PATH) === '/granted') {
    /* Get status and grantAccessToken from ready2order */
    $status = get_value('status');
    $grantAccessToken = get_value('grantAccessToken');
    if ($status !== 'approved' /* check if status */ || $grantAccessToken !== $_SESSION['grantAccessToken'] /* Check if grantAccessToken is valid */) {
        echo 'ERROR! Not Authorized';
        exit;
    }

    /* Get accountToken from ready2order and save as session token */
    $accountToken = get_value('accountToken');
    $_SESSION['accountToken'] = $accountToken;

    /* Redirect to index.php */
    header('Location: ' . 'http://' . $_SERVER['HTTP_HOST'], true, 301);
} else {
    $client = new Client($_SESSION['accountToken']);
    print_r($client->get('orders'));
}
