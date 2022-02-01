<?php

use ready2order\Client;


/**
 * Gets all orders from the Ready2Order API.
 * @param Client $client
 * @return array
 */
function get_all_orders(Client $client): array
{
    return $client->get('document/invoice', [
        'items' => true
    ]);
}

/**
 * Prints all orders.
 * @param array $orders
 * @return void
 */
function print_all_orders(array $orders)
{
    echo "<table>
            <tr>
                <th>Produkt</th>
                <th>Anzahl</th>
                <th>Datum</th>
                <th>Bezahlt</th>
            </tr>";
    foreach ($orders['invoices'] as $invoice) {
        print_order($invoice['items'], true);
    }
    echo "</table>";
}

/**
 * Prints orders from Ready2Order API.
 * @param array $items
 * @param bool $is_payed
 * @return void
 */
function print_order(array $items, bool $is_payed)
{
    $name = $is_payed ? 'item_product_name' : 'order_product_name';
    $quantitiy = $is_payed ? 'item_quantity' : 'order_quantity';
    $timestamp = $is_payed ? 'item_timestamp' : 'order_created_at';
    $payed = $is_payed ? 'Ja' : 'Nein';

    foreach ($items as $item) {
        echo "<tr>
            <td>$item[$name]</td>
            <td>$item[$quantitiy]</td>
            <td>$item[$timestamp]</td>
            <td>$payed</td>
        </tr>";
    }
}