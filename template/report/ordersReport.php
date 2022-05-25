<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

declare(strict_types=1);
$amount_orders_by_name = $_SESSION['$amount_orders_by_name'];

$amount_orders = array_reduce($amount_orders_by_name, static function ($carry, $order) {
    return $carry + $order;
}, 0);
?>

Heute gab es <?= $amount_orders ?> Bestellungen.
