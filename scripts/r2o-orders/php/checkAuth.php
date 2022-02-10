<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

function is_logged_in(): bool
{
    /* init Client with account Token */
    $client = get_client();
    if ($client === false) {
        return false;
    }
    try {
        $client->get('company');
        return isset($_SESSION['grantAccessToken'], $_SESSION['accountToken']);
    } catch (Exception) {
        return false;
    }
}
