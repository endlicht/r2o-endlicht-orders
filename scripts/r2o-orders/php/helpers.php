<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
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

/**
 * Safe value to file.
 */
function safe_to_file(string $folderpath, string $filename, string $value): bool
{
    if (!is_dir($folderpath) && !mkdir($folderpath, 0777, true) && !is_dir($folderpath)) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', $folderpath));
    }
    $file = fopen($folderpath . '/' . $filename, 'wb');
    if ($file === false) {
        return false;
    }
    if (fwrite($file, $value) === false) {
        return false;
    }
    if (fclose($file) === false) {
        return false;
    }
    return true;
}

$SERVER_ADDRESS = $_SESSION['SERVER_ADDRESS'] ?? "http://{$_SERVER['HTTP_HOST']}";

/**
 * Creates link with SERVER_ADDRESS as base.
 * @param string $link
 * @return string
 */
function create_internal_link(string $link = ''): string
{
    global $SERVER_ADDRESS;
    return $SERVER_ADDRESS . $link;
}