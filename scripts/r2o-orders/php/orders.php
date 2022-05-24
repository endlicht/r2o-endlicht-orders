<?php
declare(strict_types=1);

use ready2order\Client;

$amount_orders = 0;
$amount_recups = 0;

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
        return $client->get('document/invoice', ['items' => TRUE, 'dateFrom' => $date])['invoices'];
    } catch (Exception) {
        return FALSE;
    }
}


/**
 * Count each single item in an order.
 *
 * @return void
 */
function count_order(): void
{
    global $amount_orders;
    $amount_orders++;
}

/**
 * Increment recups if bought and decrement if brought back.
 *
 * @param string $item_name
 *
 * @return void
 */
function count_recups(string $item_name): void
{
    global $amount_recups;
    if ($item_name === 'Pfand Recup zurück') {
        --$amount_recups;
    } elseif ($item_name === 'Pfand Recup') {
        ++$amount_recups;
    }
}