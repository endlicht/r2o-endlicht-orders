<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

$client = get_client();
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
    <h3>Hallo. Hier siehst du die letzten Bestellungen.</h3>
    <?php
} else {
    ?>
    <h3>Der Tag ist geschlossen. Bis morgen :)</h3>
    <?php
}
?>

