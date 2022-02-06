<?php
/*
*    endlicht-r2o-back: The endlicht ready to order application.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

use JetBrains\PhpStorm\Pure;
use ready2order\Client;

/**
 * Get or create Client instance.
 * @param string|null $accountToken
 * @return false|Client
 */
#[Pure] function get_client(string|null $accountToken = null): false|Client
{
    if (isset($_SESSION['client'])) {
        return $_SESSION['client'];
    }
    if ($accountToken !== null) {
        /* Try accountToken from param to create new Client */
        return new Client($accountToken);
    }
    if (isset($_SESSION['accountToken'])) {
        /* Try accountToken from session to create new Client */
        return new Client($_SESSION['accountToken']);
    }
    /* If accountToken is not set in session return */
    return false;
}
