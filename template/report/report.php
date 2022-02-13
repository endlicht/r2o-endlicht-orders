<?php
if (get_client_if_logged_in() !== false) {
    ?>
    <div class="card">
        <h5 class="card-header border-0">
            <div class="d-flex justify-content-between">
                <h5 class="card-title">Übersicht</h5>
            </div>
        </h5>
        <div class="card-body">
            <div class="list-group">
                <div class="list-group-item">
                    <?php require_once("template/report/dailyReport.php"); ?>
                </div>
                <div class="list-group-item">
                    <?php require_once("template/report/ordersReport.php"); ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
