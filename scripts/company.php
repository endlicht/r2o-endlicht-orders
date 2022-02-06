<?php
/*
*    endlicht-r2o-back: The endlicht ready to order application.
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

