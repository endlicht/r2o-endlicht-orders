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
$key_name = 'item_product_name';
$key_quantity = 'item_quantity';
$key_timestamp = 'item_timestamp';
$key_timestamp_invoice = 'invoice_timestamp';

$PAST_HOURS = 24;
/* Current date */
$timestamp_now = date('Y-m-d', time() - (60 * 60 * $PAST_HOURS));

function get_orders(string|null $date = null): array|false
{
    global $client, $timestamp_now;
    if ($date === null) {
        $date = $timestamp_now;
    }

    try {
        return $client->get('document/invoice', ['items' => true, 'dateFrom' => $date])['invoices'];
    } catch (Exception) {
        return false;
    }
}

$orders = get_orders();
if ($orders === false) {
    return;
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
    if (count($orders) === 0) {
        ?>
        <tr>
            <td colspan="3">Keine Bestellungen gefunden</td>
        </tr>
        <?php
    } else {
        foreach ($orders as $invoices) {
            foreach ($invoices['items'] as $item) {
                /* Time as string */
                $time = date('H:i, d.m.Y', strtotime($item[$key_timestamp]));
                ?>
                <tr>
                    <td class="product-name"><?php echo $item[$key_name] ?></td>
                    <td class="product-quantity"><?php echo $item[$key_quantity] ?></td>
                    <td colspan="100%" class="timestamp"><?php echo $time ?></td>
                </tr>
            <?php }
        }
    } ?>
    </tbody>
</table>
