<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

require __DIR__ . '/vendor/autoload.php';

include_once("scripts/r2o-orders/php/auth.php");
include_once("scripts/r2o-orders/php/helpers.php");
include_once("scripts/r2o-orders/php/company.php");

/* Used to load private key from .env file */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

/* If session is not set start it */
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
<body class="sidebar-mini sidebar-is-opening">
<div class="wrapper">

    <?php
    include_once("template/sidebar.php");
    include_once("template/navbar.php");
    ?>
    <div class="content-wrapper">
        <?php
        if (is_connected()) {
            if ($PARSED_URL === '/auth') {
                require("pages/auth.php");
            } else if ($PARSED_URL === '/token') {
                include_once('pages/token.php');
            } else if ($PARSED_URL === '/logout') {
                require("pages/logout.php");
            } else if ($PARSED_URL === '/granted') {
                require("pages/granted.php");
            } else if ($PARSED_URL === '/') {
                $client = get_client_if_logged_in();
                if ($client === false) {
                    require("pages/login.php");
                } else {
                    require("pages/dashboard.php");
                }
            } else {
                include_once("pages/404.php");
            }
        } else {
            require("pages/network_error.php");
        }
        ?>
    </div>
</div>
<?php include_once("pages/footer.php"); ?>
</body>
</html>
