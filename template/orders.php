<?php
declare(strict_types=1);
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */


/* Get client */
global $client;
if ($client === FALSE) {
    return;
}

$orders = get_orders($client);
if ($orders === FALSE) {
    return;
}

/* Define keys for table */
$key_name = 'item_name';
$key_quantity = 'item_quantity';
$key_timestamp = 'item_timestamp';
$key_timestamp_invoice = 'invoice_timestamp';
$key_item_id = 'item_id';

?>
<style>
    .order-item {
        cursor: pointer;
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: larger;
    }

    .order-item.finished {
        background-color: lightgreen !important;
    }
</style>
<div class="card">
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h5 class="card-title">Bestellungen</h5>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
                <th scope="col">Produkt</th>
                <th scope="col">Anzahl</th>
                <th scope="col">Datum</th>
            </tr>
            </thead>
            <tbody>

            <?php
            if (count($orders) === 0) {
                ?>
                <tr>
                    <td colspan="3">Aktuell gibt es keine Bestellungen.</td>
                </tr>
                <?php
            } else {
                foreach ($orders as $invoices) {
                    foreach ($invoices['items'] as $item) {
                        count_order();
                        count_recups($item[$key_name]);
                        /* Time as string */
                        $time = date('H:i, d.m.Y', strtotime($item[$key_timestamp]));
                        ?>
                        <tr onclick="toggle_item_as_finished(<?=
                        $item[$key_item_id] ?>)"
                            id="<?=
                            'item_' . $item[$key_item_id] ?>" class="order-item">
                            <td class="product-name"><?=
                                $item[$key_name] ?></td>
                            <td class="product-quantity"><?=
                                $item[$key_quantity] ?></td>
                            <td colspan="100%" class="timestamp"><?=
                                $time ?></td>
                        </tr>
                        <?php
                    }
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    function toggle_item_as_finished(orderId) {
        if (is_finished('item_' + orderId)) {
            localStorage.setItem('item_' + orderId, '0');
            document.getElementById('item_' + orderId).classList.remove('finished');
        } else {
            localStorage.setItem('item_' + orderId, '1');
            document.getElementById('item_' + orderId).classList.add('finished');
        }
    }

    function is_finished(orderId) {
        return (localStorage.getItem(orderId) ?? '0') === '1';
    }

    Array.from(document.getElementsByClassName('order-item')).forEach((el) => {
        if (is_finished(el.id)) {
            el.classList.add('finished');
        }
    })
</script>
