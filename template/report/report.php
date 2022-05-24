<?php
declare(strict_types=1);
global $client;

if ($client !== FALSE) {
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
                </div>
                <div class='list-group-item'>
                    <?php
                    require __DIR__ . '/recupReport.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
} ?>
