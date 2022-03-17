<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

$is_logged_in = get_client_if_logged_in() !== false;
$SERVER_ADDRESS = create_internal_link();
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" id="sidebar-toggler" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <?php if (!$is_logged_in) { ?>
            <li class="nav-item d-none d-sm-inline-block">
                <!-- Link to authenticate at ready2order API -->
                <a href="<?php echo create_internal_link('/auth'); ?>" class="nav-link">Anmelden</a>
            </li>
        <?php } ?>
        <?php if ($is_logged_in) { ?>
            <li class="nav-item d-none d-sm-inline-block">
                <!-- Link to refresh page -->
                <a href="<?php echo create_internal_link(); ?>" class="nav-link">Aktualisieren</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <!-- Link to logout -->
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
</nav>
<script>
    /* Toggle between showing and hiding the sidebar */
    document.addEventListener('DOMContentLoaded', () => {
        /* When DOM is loaded add event listeners */
        const TOGGLER = document.getElementById("sidebar-toggler")
        const BODY = document.getElementsByTagName("BODY")[0]
        const CONTENT = document.getElementsByClassName("content-wrapper")[0]

        if (TOGGLER !== null) {
            TOGGLER.addEventListener("click", () => {
                if (window.screen.width >= 768) {
                    if (!BODY.classList.contains("sidebar-collapse")) {
                        BODY.classList.add("sidebar-collapse")
                    } else {
                        BODY.classList.remove("sidebar-collapse")
                    }
                    BODY.classList.remove("sidebar-open")
                    BODY.classList.remove("sidebar-closed")
                } else {
                    BODY.classList.remove("sidebar-collapse")
                    if (BODY.classList.contains("sidebar-open")) {
                        BODY.classList.remove("sidebar-open")
                        BODY.classList.add("sidebar-closed")
                    } else {
                        BODY.classList.add("sidebar-open")
                        BODY.classList.remove("sidebar-closed")
                    }
                }
            })
        }

        if (CONTENT !== null) {
            CONTENT.addEventListener("click", () => {
                if (768 <= window.screen.width && window.screen.width <= 992 && (BODY.classList.contains("sidebar-open") || !BODY.classList.contains("sidebar-collapse"))) {
                    BODY.classList.remove("sidebar-open")
                    BODY.classList.add("sidebar-collapse")
                } else if (768 >= window.screen.width) {
                    BODY.classList.remove("sidebar-collapse")
                    BODY.classList.remove("sidebar-open")
                    BODY.classList.add("sidebar-closed")
                }
            })
        }
    })
</script>
