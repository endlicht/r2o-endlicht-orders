<?php
/*
*    endlicht-r2o-back: The endlicht ready to order application.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

require __DIR__ . '/vendor/autoload.php';

include("scripts/auth.php");
include("scripts/helpers.php");
include_once("scripts/client.php");
include_once("scripts/checkAuth.php");
include_once("scripts/company.php");

/* Used to load private key from .env file */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

session_start();

$URL = $_SERVER['REQUEST_URI'];
$SERVER_ADDRESS = "http://{$_SERVER['HTTP_HOST']}";

$PARSED_URL = parse_url($URL, PHP_URL_PATH);

$TITLE = 'Bestellungen'; /* get_company_name() . " Bestellungen"; */

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="default-src 'none'; base-uri 'none'; child-src 'self'; form-action 'self'; frame-src 'self'; font-src 'self'; connect-src 'self'; img-src 'self'; manifest-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'"
          http-equiv="Content-Security-Policy">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Endlicht Bestellungen">
    <meta name="author" content="Josef Müller">
    <title><?php echo $TITLE; ?></title>
    <style>
        body {
            text-align: left;
        }

        nav {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: large;
        }

        thead {
            background-color: #a0aaaa;
        }

        tr, td {
            border: thin solid black;
        }

        .button {
            background-color: #a0aaaa;
            border: thin solid black;
            color: black;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: larger;
            font-weight: bold;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<h1><?php echo $TITLE; ?></h1>
<nav class="navigation">
    <?php if (!is_logged_in()) { ?>
        <!-- Button to authenticate at ready2order API -->
        <a href="<?php echo $SERVER_ADDRESS . '/auth'; ?>" class="button">Anmelden</a>
    <?php } ?>
    <?php if (is_logged_in()) { ?>
        <!-- Button to refresh page -->
        <a href="<?php echo $SERVER_ADDRESS; ?>" class="button">Aktualisieren</a>
        <!-- Show last time the page was refreshed -->
        <?php echo "Letzte Aktualisierung: " . date("d.m.Y H:i:s"); ?>
    <?php } ?>
</nav>

<?php

$client = get_client();

if ($PARSED_URL === '/auth') {
    /* Authenticate developer at ready2order API */
    try {
        $grantAccessResponse = auth_as_developer($_ENV['DEVELOPER_TOKEN'], $SERVER_ADDRESS . '/granted');
    } catch (JsonException $e) {
        ?><h2>Ein Fehler beim Authentifizieren als Entwickler ist aufgetreten!</h2><?php
        exit();
    }
    /* Safe grantAccessToken to session */
    $_SESSION['grantAccessToken'] = $grantAccessResponse['grantAccessToken'];

    /* Redirect to ready2order authorization page */
    header('Location: ' . $grantAccessResponse['grantAccessUri'], true, 302);
} else if ($PARSED_URL === '/token') {
    /* Show all tokens */
    require('template/token.php');
} else if ($PARSED_URL === '/granted') {
    /* Get status and grantAccessToken from ready2order */
    $status = get_value('status');
    $grantAccessToken = get_value('grantAccessToken');
    if ($status !== 'approved' /* check status */ || $grantAccessToken !== $_SESSION['grantAccessToken'] /* Check if grantAccessToken is valid */) {
        ?><h2>Ein Fehler ist beim Anmelden bei ready2order aufgetreten!</h2><?php
        exit();
    }

    /* Get accountToken from ready2order and save it as a SESSION Token */
    $accountToken = get_value('accountToken');

    /* Restart session and invalidate session data */
    session_destroy();
    session_start();

    /* Save tokens and client to session */
    $_SESSION['accountToken'] = $accountToken;
    $_SESSION['grantAccessToken'] = $grantAccessToken;
    $_SESSION['client'] = get_client($accountToken);

    /* Redirect to index.php */
    header('Location: ' . $SERVER_ADDRESS, true, 302);
} else {
    /* Inform if day is opened */
    include("template/dailyReport.php");

    /* Show orders */
    include("template/orders.php");
}
?>
</body>
</html>
