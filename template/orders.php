<?php

use ready2order\Client;

/* init Client with account Token */
$client = new Client($_SESSION['accountToken']);

/* define keys */
$name = 'item_product_name';
$quantitiy = 'item_quantity';
$timestamp = 'item_timestamp';
$timestamp_invoice = 'invoice_timestamp';

$orders = $client->get('document/invoice', ['items' => true]);

?>

<table>
    <thead>
    <tr>
        <th>Produkt</th>
        <th>Anzahl</th>
        <th>Datum</th>
    </tr>
    </thead>
    <tbody>

    <?php
    foreach ($orders['invoices'] as $invoices) {
        foreach ($invoices['items'] as $item) {
        $time = date('H:i, d.m.Y', strtotime($item[$timestamp]));
            ?>
            <tr>
                <td class="product-name"><?php echo $item[$name] ?></td>
                <td class="product-quantity"><?php echo $item[$quantitiy] ?></td>
                <td colspan="100%" class="timestamp"><?php echo $time ?></td>
            </tr>
        <?php }
    } ?>
    </tbody>
</table>