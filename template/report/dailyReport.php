<?php
declare(strict_types=1);
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

global $client;

if ($client === FALSE) {
    return;
}

try {
    $status = $client->get('dailyReport/status');
} catch (Exception $e) {
    return;
}

$day_is_opened = $status['status'] === 'open';
$_SESSION['open'] = $day_is_opened;

if ($day_is_opened) {
    ?>
    Der Tag ist geöffnet.
    <?php
} else {
    ?>
    Der Tag ist geschlossen.
    <?php
}
?>

