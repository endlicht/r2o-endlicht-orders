<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

function get_company_name(): string {
    $client = get_client();
    if ($client === false) {
        return '';
    }
    return $client->get('company')['company_name'];
}

