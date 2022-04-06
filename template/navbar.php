<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

$is_logged_in = get_client_if_logged_in() !== false;
$SERVER_ADDRESS = create_internal_link();
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (!$is_logged_in) { ?>
                    <li class="nav-item">
                        <!-- Link to authenticate at ready2order API -->
                        <a href="<?php echo create_internal_link('/auth'); ?>" class="nav-link">Anmelden</a>
                    </li>
                <?php } ?>
                <?php if ($is_logged_in) { ?>
                    <li class="nav-item">
                        <!-- Link to refresh page -->
                        <a href="<?php echo create_internal_link(); ?>" class="nav-link">Aktualisieren</a>
                    </li>
                    <li class="nav-item">
                        <!-- Link to log out -->
                        <a href="<?php echo create_internal_link('/logout'); ?>" class="nav-link">Abmelden</a>
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
        </div>
    </div>
</nav>
