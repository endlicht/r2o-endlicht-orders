<?php
/*
*    endlicht-r2o-back: The endlicht ready to order application.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

use JetBrains\PhpStorm\Pure;

/**
 * Escape all HTML characters.
 * @param string|null $string $string
 * @return string
 */
function clean_string(string|null $string): string
{
    if ($string === null) {
        return '';
    }
    return htmlspecialchars($string, ENT_QUOTES);
}

/**
 * Get value from global $_GET variable.
 * @param string|null $key
 * @return string
 */
#[Pure] function get_value(string|null $key): string
{
    if ($key !== null && isset($_GET[$key])) {
        return clean_string($_GET[$key]);
    }
    return '';
}