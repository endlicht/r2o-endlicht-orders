<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

?>
<div class="row">
    <div class="col">
        <h2>Authentifizierung</h2>
    </div>
</div>
<div class="row">
    <div class="col">
        <?php
        /* Get status and grantAccessToken from ready2order */
        $status = get_value('status');
        $grantAccessToken = get_value('grantAccessToken');
        if ($status !== 'approved' /* check status */ || !isset($_SESSION['grantAccessToken']) || $grantAccessToken !== $_SESSION['grantAccessToken'] /* Check if grantAccessToken is valid */) {
            ?>
            Authentifizierung fehlgeschlagen.
            <?php
        } else {
            /* Save tokens and client to session */
            $_SESSION['grantAccessToken'] = $grantAccessToken;

            /* Get accountToken from ready2order and save it as a SESSION Token */
            $accountToken = get_value('accountToken');
            update_and_get_account_token($accountToken);

            /* Update client */
            get_client_if_logged_in();
            ?>
            Anmeldung erfolgreich!
            Weiterleitung zum Dashboard...
            <script>
                setTimeout(() => {
                    window.location.href = '<?php echo create_internal_link(); ?>';
                }, 200);
            </script>
        <?php } ?>
    </div>
</div>
