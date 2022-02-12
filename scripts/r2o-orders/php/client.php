<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

use ready2order\Client;

/**
 * Get or create Client instance.
 * @return false|Client
 */
function update_and_get_client(): false|Client
{
    $client = false;
    if (isset($_SESSION['client'])) {
        return $_SESSION['client'];
    }

    $accountToken = update_and_get_account_token();
    if ($accountToken !== false) {
        $client = new Client($accountToken);
    }

    if ($client !== false) {
        $_SESSION['client'] = $client;
    }

    return $client;
}
