<?php
$client = get_client_if_logged_in();
if ($client === false) {
    ?>
    <div class="content-header">
        <div class="content-fluid">
            <div class="col-sm-6">
                <h1 class="m-0">Hallo.</h1>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            Bitte melde dich an.<br>
            <a href="<?php echo create_internal_link('/auth'); ?>" class="link-primary">Anmelden</a>
        </div>
    </div>
    <?php
} else {
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
    <?php
}