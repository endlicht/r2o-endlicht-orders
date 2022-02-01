<?php

require __DIR__ . '/vendor/autoload.php';

include("auth.php");
include("app.php");
include("helpers.php");

use ready2order\Client;

/* Used to load private key from .env file */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

session_start();

$URL = $_SERVER['REQUEST_URI'];
$SERVER_ADDRESS = "http://{$_SERVER['HTTP_HOST']}";

$PARSED_URL = parse_url($URL, PHP_URL_PATH);

if ($PARSED_URL === '/auth' || ($PARSED_URL !== '/granted' && /* check if tokens are set */ (!isset($_SESSION['grantAccessToken']) || !isset($_SESSION['accountToken'])))) {
    $grantAccessResponse = auth_as_developer($_ENV['DEVELOPER_TOKEN'], $SERVER_ADDRESS . '/granted');
    $_SESSION['grantAccessToken'] = $grantAccessResponse['grantAccessToken'];

    /* Redirect to ready2order authorization page */
    header('Location: ' . $grantAccessResponse['grantAccessUri'], true, 301);
} else if ($PARSED_URL === '/token') {
    echo "<div>DEVELOPER TOKEN: {$_ENV['DEVELOPER_TOKEN']}</div><div>GRANT ACCESS TOKEN: {$_SESSION['grantAccessToken']}</div>";
} else if ($PARSED_URL === '/granted') {
    /* Get status and grantAccessToken from ready2order */
    $status = get_value('status');
    $grantAccessToken = get_value('grantAccessToken');
    if ($status !== 'approved' /* check status */ || $grantAccessToken !== $_SESSION['grantAccessToken'] /* Check if grantAccessToken is valid */) {
        echo 'ERROR! Not Authorized';
        exit;
    }

    /* Get accountToken from ready2order and save as session token */
    $accountToken = get_value('accountToken');
    $_SESSION['accountToken'] = $accountToken;

    /* Redirect to index.php */
    header('Location: ' . $SERVER_ADDRESS, true, 301);
} else {
    $client = new Client($_SESSION['accountToken']);
    print_all_orders(get_all_orders($client));
}
