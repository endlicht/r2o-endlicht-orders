<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

?>
<div class="row">
    <div class="col">
        <h2>Dashboard</h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <?php
        /* Show orders */
        include("template/orders.php");
        ?>
    </div>
    <div class="col-lg-6">
        <?php
        /* Inform if day is opened */
        include("template/report/report.php");
        ?>
    </div>
</div>
