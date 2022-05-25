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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $_SESSION['token'] = get_random_token();
    $_SESSION['token_field'] = get_random_token();
}
?>

<div class="card">
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h5 class="card-title">Übersicht</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="list-group">
            <div class="list-group-item">
                <?php
                require __DIR__ . '/dailyReport.php'; ?>
            </div>
            <div class="list-group-item">
                <?php
                require __DIR__ . '/ordersReport.php'; ?>
                <button id="send_report">
                    Report per E-Mail senden
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('send_report').addEventListener('click', () => {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/api?send_report_email&<?= $_SESSION['token_field'] ?>=<?= $_SESSION['token'] ?>', true);
        xhr.send();
    })
</script>

