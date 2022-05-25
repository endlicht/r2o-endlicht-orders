<?php
declare(strict_types=1);
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

use ready2order\Client;

$amount_orders_by_name = [];

/**
 * Get orders via API.
 *
 * @param Client      $client
 * @param string|null $date
 *
 * @return array|false
 */
function get_orders(Client $client, ?string $date = NULL): array|false
{
    /* config */
    static $time_range = 24;

    /* current date */
    $timestamp_now = date('Y-m-d', time() - (60 * 60 * $time_range));

    if ($date === NULL) {
        $date = $timestamp_now;
    }

    try {
        return $client->get('document/invoice', ['items' => TRUE, 'dateFrom' => $date, 'payments' => FALSE])['invoices'];
    } catch (Exception) {
        return FALSE;
    }
}


/**
 * Count all orders.
 *
 * @param string $item_name
 *
 * @return void
 */
function count_orders_by_name(string $item_name): void
{
    global $amount_orders_by_name;

    $clean_item_name = $item_name;
    $increment = TRUE;

    /* if “zurück” is found then decrement */
    if (str_contains($item_name, 'zurück')) {
        $increment = FALSE;
        $clean_item_name = trim(explode('zurück', $item_name)[0]);
    }

    if (!array_key_exists($clean_item_name, $amount_orders_by_name)) {
        $amount_orders_by_name[$clean_item_name] = 0;
    }

    /* increment or decrement amount depending on state */
    $increment ? $amount_orders_by_name[$clean_item_name]++ : $amount_orders_by_name[$clean_item_name]--;
}

/**
 * Sends amount of recups via email.
 *
 * @param array $amount_orders_by_name
 *
 * @return void
 */
function send_orders(array $amount_orders_by_name): void
{

    $orders = '';
    foreach ($amount_orders_by_name as $name => $amount) {
        $orders .= '<li>' . $name . ': ' . $amount . '</li>';
    }

    send_mail('jo391mue@htwg-konstanz.de', 'Recups', "
        Hallo,
        <p>
            heute wurden folgende Produkte verkauft:
            <ul>
                $orders
            </ul>
        </p>
    " . email_signature());
}
