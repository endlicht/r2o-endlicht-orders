<?php
declare(strict_types=1);
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

/**
 * Gets company name via API.
 *
 * @return string
 */
function get_company_name(): string
{
    global $client;
    if ($client === FALSE) {
        return '';
    }
    return $client->get('company')['company_name'];
}

