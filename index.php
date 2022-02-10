<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

require __DIR__ . '/vendor/autoload.php';

include("scripts/r2o-orders/php/auth.php");
include("scripts/r2o-orders/php/helpers.php");
include_once("scripts/r2o-orders/php/client.php");
include_once("scripts/r2o-orders/php/checkAuth.php");
include_once("scripts/r2o-orders/php/company.php");

/* Used to load private key from .env file */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

session_start();

$URL = $_SERVER['REQUEST_URI'];
$SERVER_ADDRESS = "http://{$_SERVER['HTTP_HOST']}";

$PARSED_URL = parse_url($URL, PHP_URL_PATH);

$TITLE = get_company_name() . " Bestellungen";

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>
<!doctype html>
<html lang="de">
<?php require("template/header.php"); ?>
<body>
<nav class="navbar navbar-dark bg-dark mb-3">
    <div class="container-fluid">
        <h1 class="navbar-brand"><?php echo $TITLE; ?></h1>
        <ul class="navbar-nav m-auto">
            <?php if (!is_logged_in()) { ?>
                <li class="nav-item fs-4">
                    <!-- Link to authenticate at ready2order API -->
                    <a href="<?php echo $SERVER_ADDRESS . '/auth'; ?>" class="nav-link">Anmelden</a>
                </li>
            <?php } ?>
            <?php if (is_logged_in()) { ?>
                <li class="nav-item fs-4">
                    <!-- Link to refresh page -->
                    <a href="<?php echo $SERVER_ADDRESS; ?>" class="nav-link">Aktualisieren</a>
                </li>
            <?php } ?>
        </ul>
        <span class="navbar-text text-secondary">
            <!-- Show last time the page was refreshed -->
            <?php echo "Letzte Aktualisierung: " . date("d.m.Y H:i:s"); ?>
        </span>
    </div>
</nav>

<div class="container-fluid my-3">

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
        include("template/report/report.php");
        ?>
        <div class="my-3">
            <?php
            /* Show orders */
            include("template/orders.php");
            ?>
        </div>
        <?php
    }
    ?>
</div>
</body>
</html>
