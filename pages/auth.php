<div class="content-header">
    <div class="content-fluid">
        <div class="col-sm-6">
            <h1 class="m-0">Anmeldung bei ready2order</h1>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <?php
        /*
        *    r2o-orders: The simple way to show orders from r2o API.
        *    Copyright (c) 2022 Josef Müller
        *
        *    Please see LICENSE file for your rights under this license. */

        include_once("scripts/r2o-orders/php/auth.php");

        /* Authenticate developer at ready2order API */
        try {
            $grantAccessResponse = auth_as_developer($_ENV['DEVELOPER_TOKEN'], create_internal_link('/granted'));
            if ($grantAccessResponse === false) {
                ?><h2>Ein Fehler beim Authentifizieren als Entwickler ist aufgetreten!</h2><?php
                exit();
            }
        } catch (JsonException $e) {
            ?><h2>Ein Fehler beim Authentifizieren als Entwickler ist aufgetreten!</h2><?php
            exit();
        }

        /* Safe grantAccessToken to session */
        $_SESSION['grantAccessToken'] = $grantAccessResponse['grantAccessToken'];

        ?>
        Weiterleitung zur Authentifizierung bei ready2order...
    </div>
</div>
<script>
    setTimeout(() => {
        window.location.href = '<?php echo $grantAccessResponse['grantAccessUri']; ?>';
    }, 2000);
</script>
