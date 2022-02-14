<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

?>
<div class="content-header">
    <div class="content-fluid">
        <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
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
    </div>
</div>
