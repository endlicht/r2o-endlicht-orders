<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

$client = get_client_if_logged_in();
if ($client === false) {
    return;
}

/* Define keys for table */
$key_name = 'item_name';
$key_quantity = 'item_quantity';
$key_timestamp = 'item_timestamp';
$key_timestamp_invoice = 'invoice_timestamp';
$key_item_id = 'item_id';

$PAST_HOURS = 24;
/* Current date */
$timestamp_now = date('Y-m-d', time() - (60 * 60 * $PAST_HOURS));

function get_orders(string|null $date = null, string|null $test_data = null): array|false
{
    if ($test_data !== null) {
        return $test_data;
    }

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

$amount_orders = 0;

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
                        $amount_orders++;
                        /* Time as string */
                        $time = date('H:i, d.m.Y', strtotime($item[$key_timestamp]));
                        ?>
                        <tr onclick="toggle_item_as_finished(<?php echo $item[$key_item_id] ?>)"
                            id="<?php echo 'item_' . $item[$key_item_id] ?>" class="order-item">
                            <td class="product-name"><?php echo $item[$key_name] ?></td>
                            <td class="product-quantity"><?php echo $item[$key_quantity] ?></td>
                            <td colspan="100%" class="timestamp"><?php echo $time ?></td>
                        </tr>
                    <?php }
                }
            }
            $_SESSION['amount_orders'] = $amount_orders;

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
