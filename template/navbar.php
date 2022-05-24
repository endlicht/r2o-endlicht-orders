<?php
declare(strict_types=1);
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

global $client;
$is_logged_in = $client !== FALSE;
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                if (!$is_logged_in) { ?>
                    <li class="nav-item">
                        <!-- Link to authenticate at ready2order API -->
                        <a href='/auth' class="nav-link">Anmelden</a>
                    </li>
                    <?php
                } ?>
                <?php
                if ($is_logged_in) { ?>
                    <li class="nav-item">
                        <a href='/' class="nav-link">Aktualisieren</a>
                    </li>
                    <li class="nav-item">
                        <a href="/logout" class="nav-link">Abmelden</a>
                    </li>
                    <?php
                } ?>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li>
            <span class="navbar-text text-secondary">
                <!-- Show last time the page was refreshed -->
                <?= 'Letzte Aktualisierung: ' . date('d.m.Y H:i:s') ?>
            </span>
                </li>
            </ul>
        </div>
    </div>
</nav>
