<?php
$is_logged_in = get_client_if_logged_in() !== false;
$SERVER_ADDRESS = create_internal_link();
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <?php if (!$is_logged_in) { ?>
            <li class="nav-item d-none d-sm-inline-block">
                <!-- Link to authenticate at ready2order API -->
                <a href="<?php echo $SERVER_ADDRESS . '/auth'; ?>" class="nav-link">Anmelden</a>
            </li>
        <?php } ?>
        <?php if ($is_logged_in) { ?>
            <li class="nav-item d-none d-sm-inline-block">
                <!-- Link to refresh page -->
                <a href="<?php echo $SERVER_ADDRESS; ?>" class="nav-link">Aktualisieren</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <!-- Link to logout -->
                <a href="<?php echo $SERVER_ADDRESS . '/logout'; ?>" class="nav-link">Abmelden</a>
            </li>
        <?php } ?>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li>
            <span class="navbar-text text-secondary">
                <!-- Show last time the page was refreshed -->
                <?php echo "Letzte Aktualisierung: " . date("d.m.Y H:i:s"); ?>
            </span>
        </li>
    </ul>
</nav>