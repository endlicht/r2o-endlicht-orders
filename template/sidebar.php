<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

$is_logged_in = get_client_if_logged_in() !== false;
$SERVER_ADDRESS = create_internal_link();
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo create_internal_link(); ?>" class="brand-link">
        <span class="brand-text font-weight-light">
            <?php echo get_company_name() . " Bestellungen"; ?>
        </span>
    </a>


    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item menu-open">
                    <ul class="nav nav-treeview">
                        <?php if (!$is_logged_in) { ?>
                            <li class="nav-item">
                                <!-- Link to authenticate at ready2order API -->
                                <a href="<?php echo create_internal_link('/auth'); ?>" class="nav-link">
                                    <em class="fas fa-arrow-right-to-bracket nav-icon"></em>
                                    <p>Anmelden</p>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if ($is_logged_in) { ?>
                            <!-- Link to refresh page -->
                            <a href="<?php echo create_internal_link(); ?>" class="nav-link">
                                <em class="fas fa-rotate nav-icon"></em>
                                <p>Aktualisieren</p>
                            </a>
                            <!-- Link to refresh page -->
                            <a href="<?php echo create_internal_link('/statistics'); ?>" class="nav-link">
                                <em class="fas fa-chart-column nav-icon"></em>
                                <p>Statistiken</p>
                            </a>
                            <!-- Link to logout -->
                            <a href="<?php echo create_internal_link('/logout'); ?>" class="nav-link">
                                <em class="fas fa-right-from-bracket nav-icon"></em>
                                <p>Abmelden</p>
                            </a>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>

