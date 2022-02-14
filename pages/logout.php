<div class="content-header">
    <div class="content-fluid">
        <div class="col-sm-6">
            <h1 class="m-0">Abmeldung von ready2order</h1>
        </div>
    </div>
</div>
<?php
/* Revoke access from ready2order */
$client = get_client_if_logged_in();
if ($client !== false) {
    $client->post('access/revoke');
    ?>
    <div class="content">
        <div class="container-fluid">
            Weiterleitung zur Startseite...
        </div>
    </div>
    <script>
        setTimeout(() => {
            window.location.href = '<?php echo create_internal_link(); ?>';
        }, 2000);
    </script>
    <?php
} else {
    ?>
    <div class="content">
        <div class="container-fluid">
            <h5 class="text-warning">
                Abmeldung fehlgeschlagen.
            </h5>
        </div>
    </div>
    <?php
}

?>