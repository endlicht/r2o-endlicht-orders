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

try {
    $status = $client->get('dailyReport/status');
} catch (Exception $e) {
    return;
}

$open = $status['status'] === 'open';
$_SESSION['open'] = $open;

if ($open) {
    ?>
    Der Tag ist geöffnet.
    <?php
} else {
    ?>
    Der Tag ist geschlossen.
    <?php
}
?>

