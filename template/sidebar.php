<?php

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
                        <li class="nav-item">
                            <a href="<?php echo create_internal_link(); ?>" class="nav-link">
                                <em class="fas fa-rotate nav-icon"></em>
                                <p>Aktualisieren</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo create_internal_link('/logout'); ?>" class="nav-link">
                                <em class="fas fa-right-from-bracket nav-icon"></em>
                                <p>Abmelden</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>

