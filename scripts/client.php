<?php
/*
*    endlicht-r2o-back: The endlicht ready to order application.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

use ready2order\Client;

/**
 * Get or create Client instance.
 * @param string|null $accountToken
 * @return false|Client
 */
function get_client(string|null $accountToken = null): false|Client
{
    $client = false;
    if (isset($_SESSION['client'])) {
        return $_SESSION['client'];
    }
    if ($accountToken !== null) {
        /* Try accountToken from param to create new Client */
        $client = new Client($accountToken);
    }
    if (isset($_SESSION['accountToken'])) {
        /* Try accountToken from session to create new Client */
        $client = new Client($_SESSION['accountToken']);
    }

    if ($client !== false) {
        /* Save Client to session */
        $_SESSION['client'] = $client;
    }

    return $client;
}
