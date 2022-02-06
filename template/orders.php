<?php
/*
*    endlicht-r2o-back: The endlicht ready to order application.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

$client = get_client();
if ($client === false) {
    return;
}

/* Define keys for table */
$name = 'item_product_name';
$quantity = 'item_quantity';
$timestamp = 'item_timestamp';
$timestamp_invoice = 'invoice_timestamp';

try {
    $orders = $client->get('document/invoice', ['items' => true]);
} catch (Exception $e) {
    ?>
    <h2>Kein Zugriff auf die Bestellungen möglich! Eine Anmeldung ist erforderlich</h2>
    <?php
    exit();
}
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
                <td class="product-quantity"><?php echo $item[$quantity] ?></td>
                <td colspan="100%" class="timestamp"><?php echo $time ?></td>
            </tr>
        <?php }
    } ?>
    </tbody>
</table>