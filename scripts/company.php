<?php
/*
*    endlicht-r2o-back: The endlicht ready to order application.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */
$client = get_client();
if ($client === false) {
    return;
}

$company_name = $client->get('company')['company_name'];
$TITLE = $company_name . " Bestellungen";

?>
<?php echo $TITLE ?>