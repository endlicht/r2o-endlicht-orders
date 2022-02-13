<div class="content-header">
    <div class="content-fluid">
        <div class="col-sm-6">
            <h1 class="m-0">Authentifizierung</h1>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <?php
        /* Get status and grantAccessToken from ready2order */
        $status = get_value('status');
        $grantAccessToken = get_value('grantAccessToken');
        if ($status !== 'approved' /* check status */ || !isset($_SESSION['grantAccessToken']) || $grantAccessToken !== $_SESSION['grantAccessToken'] /* Check if grantAccessToken is valid */) {
            ?>
            <h2>Ein Fehler ist beim Anmelden bei ready2order aufgetreten!</h2>
            <?php
            exit();
        }

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
    </div>
</div>
<script>
    setTimeout(() => {
        window.location.href = '<?php echo create_internal_link(); ?>';
    }, 2000);
</script>