<?php
declare(strict_types=1);
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

$parsed_url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
parse_str($parsed_url, $params);

if (isset($_POST, $params['send_report_email'])) {
    $token = clean_string($params[(string)($_SESSION['token_field'] ?? '')] ?? '');
    if (!$token || $token !== $_SESSION['token']) {
        exit(1);
    }
    send_orders($_SESSION['$amount_orders_by_name'] ?? []);
}