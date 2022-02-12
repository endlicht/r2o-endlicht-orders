<?php
$SERVER_ADDRESS = $_SESSION['SERVER_ADDRESS'] ?? "http://{$_SERVER['HTTP_HOST']}";
$TITLE = get_company_name() . " Bestellungen";
$is_logged_in = get_client_if_logged_in() !== false;
?>

<nav class="navbar navbar-dark bg-dark mb-3">
    <div class="container-fluid">
        <h1 class="navbar-brand"><?php echo $TITLE; ?></h1>
        <ul class="navbar-nav m-auto">
            <?php if (!$is_logged_in) { ?>
                <li class="nav-item fs-4">
                    <!-- Link to authenticate at ready2order API -->
                    <a href="<?php echo $SERVER_ADDRESS . '/auth'; ?>" class="nav-link">Anmelden</a>
                </li>
            <?php } ?>
            <?php if ($is_logged_in) { ?>
                <li class="nav-item fs-4">
                    <!-- Link to refresh page -->
                    <a href="<?php echo $SERVER_ADDRESS; ?>" class="nav-link">Aktualisieren</a>
                </li>
            <?php } ?>
        </ul>
        <span class="navbar-text text-secondary">
            <!-- Show last time the page was refreshed -->
            <?php echo "Letzte Aktualisierung: " . date("d.m.Y H:i:s"); ?>
        </span>
    </div>
</nav>