<?php
declare(strict_types=1);
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

require __DIR__ . '/../scripts/r2o-orders/php/auth.php';
?>
<div class="row">
    <div class="col">
        <h2>Weiterleitung zu ready2order ...</h2>
    </div>
</div>
<div class="row">
    <div class="col">
        <?php

        /* Authenticate developer at ready2order API */
        try {
            $grantAccessResponse = auth_as_developer($_ENV['DEVELOPER_TOKEN'], create_internal_link('/granted'));
            if ($grantAccessResponse === FALSE) {
                ?>
                Authentifizierung fehlgeschlagen.
                <?php
                exit();
            }
        } catch (JsonException $e) {
            ?>
            Authentifizierung fehlgeschlagen.
            <?php
            exit();
        }

        /* Safe grantAccessToken to session */
        $_SESSION['grantAccessToken'] = $grantAccessResponse['grantAccessToken'];

        ?>
        Bitte warten!
        <script>
            setTimeout(() => {
                window.location.href = '<?= $grantAccessResponse['grantAccessUri'] ?>';
            }, 200);
        </script>
    </div>
</div>
