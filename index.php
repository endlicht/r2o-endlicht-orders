<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

require __DIR__ . '/vendor/autoload.php';

include("scripts/r2o-orders/php/auth.php");
include("scripts/r2o-orders/php/helpers.php");
include_once("scripts/r2o-orders/php/company.php");

/* Used to load private key from .env file */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

session_start();

$URL = $_SERVER['REQUEST_URI'];

$PARSED_URL = parse_url($URL, PHP_URL_PATH);

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/* Read account token from cache if it exists */
update_and_get_account_token();

?>
<!doctype html>
<html lang="de">
<?php include_once("template/head.php"); ?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <?php
    include_once("template/sidebar.php");
    include_once("template/navbar.php");
    ?>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="content-fluid">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="content-fluid">


                <?php

                if ($PARSED_URL === '/auth') {
                    /* Authenticate developer at ready2order API */
                    try {
                        $grantAccessResponse = auth_as_developer($_ENV['DEVELOPER_TOKEN'], create_internal_link('/granted'));
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
                } else if ($PARSED_URL === '/logout') {
                    /* Revoke access from ready2order */
                    $client = get_client_if_logged_in();
                    if ($client !== false) {
                        $client->post('access/revoke');
                        /* Remove session */
                        session_destroy();
                    }
                } else if ($PARSED_URL === '/granted') {
                    /* Get status and grantAccessToken from ready2order */
                    $status = get_value('status');
                    $grantAccessToken = get_value('grantAccessToken');
                    if ($status !== 'approved' /* check status */ || !isset($_SESSION['grantAccessToken']) || $grantAccessToken !== $_SESSION['grantAccessToken'] /* Check if grantAccessToken is valid */) {
                        ?><h2>Ein Fehler ist beim Anmelden bei ready2order aufgetreten!</h2><?php
                        exit();
                    }


                    /* Restart session and invalidate session data */
                    session_destroy();
                    session_start();

                    /* Save tokens and client to session */
                    $_SESSION['grantAccessToken'] = $grantAccessToken;

                    /* Get accountToken from ready2order and save it as a SESSION Token */
                    $accountToken = get_value('accountToken');
                    update_and_get_account_token($accountToken);

                    /* Update client */
                    get_client_if_logged_in();

                    /* Redirect to index.php */
                    header('Location: ' . create_internal_link(), true, 302);
                } else {
                    ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <?php
                            /* Show orders */
                            include("template/orders.php");
                            ?>
                        </div>
                        <div class="col-lg-6">
                            <?php
                            /* Inform if day is opened */
                            include("template/report/report.php");
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
