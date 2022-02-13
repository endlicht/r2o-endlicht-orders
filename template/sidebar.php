<?php
$is_logged_in = get_client_if_logged_in() !== false;
$SERVER_ADDRESS = create_internal_link();
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Übersicht
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if (!$is_logged_in) { ?>
                            <li class="nav-item">
                                <!-- Link to authenticate at ready2order API -->
                                <a href="<?php echo $SERVER_ADDRESS . '/auth'; ?>" class="nav-link">Anmelden</a>
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

