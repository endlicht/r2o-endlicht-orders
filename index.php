<?php
declare(strict_types=1);
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

require __DIR__ . '/vendor/autoload.php';

/* Used to load private key from .env file */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require_once __DIR__ . '/scripts/r2o-orders/php/orders.php';
require_once __DIR__ . '/scripts/r2o-orders/php/auth.php';
require_once __DIR__ . '/scripts/r2o-orders/php/helpers.php';
require_once __DIR__ . '/scripts/r2o-orders/php/company.php';
require_once __DIR__ . '/scripts/r2o-orders/php/email.php';

/* If session is not set start it */
session_start();

$parsed_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

get_set_acc_tok();
$client = get_client_if_logged_in();
$title = get_company_name() . ' Bestellungen';
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="default-src 'none'; base-uri 'none'; child-src 'self'; form-action 'self'; frame-src 'self'; font-src 'self'; connect-src 'self'; img-src 'self'; manifest-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'"
          http-equiv="Content-Security-Policy">
    <meta name="description" content="Bestellungen">
    <meta name="author" content="Josef Müller">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/style/vendor/bootstrap.min.css">
</head>

<body>
<div class="container-fluid">
    <header>
        <?php
        require __DIR__ . '/template/navbar.php';
        ?>
    </header>
    <div class="row">
        <?php
        if ($parsed_url === '/auth') {
            require __DIR__ . '/pages/auth.php';
        } elseif ($parsed_url === '/token') {
            require __DIR__ . '/pages/token.php';
        } elseif ($parsed_url === '/logout') {
            require __DIR__ . '/pages/logout.php';
        } elseif ($parsed_url === '/granted') {
            require __DIR__ . '/pages/granted.php';
        } elseif ($client !== FALSE) {
            if ($parsed_url === '/') {
                require_once __DIR__ . '/pages/dashboard.php';
            } elseif ($parsed_url === '/api') {
                require __DIR__ . '/pages/api.php';
            }
        } else {
            require __DIR__ . '/pages/login.php';
        }
        ?>
    </div>
</div>
</body>
</html>
