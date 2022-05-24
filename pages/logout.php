<?php
declare(strict_types=1);
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */
?>
<div class="row">
    <div class="col">
        <h2>Abmeldung</h2>
    </div>
</div>
<div class="row">
    <div class="col">
        <?php

        /* Revoke access from ready2order */
        global $client;
        if ($client !== FALSE) {
            $client->post('access/revoke');
            ?>
            Weiterleitung zur Startseite...
            <script>
                setTimeout(() => {
                    window.location.href = '/';
                }, 200);
            </script>
            <?php
        } else {
            ?>
            Abmeldung fehlgeschlagen.
            <?php
        }
        ?>
    </div>
</div>
