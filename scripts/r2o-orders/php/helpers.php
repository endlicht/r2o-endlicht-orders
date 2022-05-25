<?php
declare(strict_types=1);
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

/**
 * Escape all HTML characters.
 *
 * @param string|null $string $string
 *
 * @return string
 */
function clean_string(string|null $string): string
{
    if ($string === NULL) {
        return '';
    }
    return htmlspecialchars($string, ENT_QUOTES);
}

/**
 * Get value from global $_GET variable.
 *
 * @param string|null $key
 *
 * @return string
 */
function get_value(string|null $key): string
{
    if ($key !== NULL && isset($_GET[$key])) {
        return clean_string($_GET[$key]);
    }
    return '';
}

/**
 * Safe value to file.
 */
function safe_to_file(string $folderpath, string $filename, string $value): bool
{
    if (!is_dir($folderpath) && !mkdir($folderpath, 0777, TRUE) && !is_dir($folderpath)) {
        throw new RuntimeException(sprintf('Directory "%s" was not created', $folderpath));
    }
    $file = fopen($folderpath . '/' . $filename, 'wb');
    if ($file === FALSE) {
        return FALSE;
    }
    if (fwrite($file, $value) === FALSE) {
        return FALSE;
    }
    if (fclose($file) === FALSE) {
        return FALSE;
    }
    return TRUE;
}

/**
 * Checks if Server is using HTTPS.
 *
 * @return bool
 */
function is_secure(): bool
{
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] === 443;
}

$SERVER_ADDRESS = $_SESSION['SERVER_ADDRESS'] ?? ((is_secure() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);

/**
 * Creates link with SERVER_ADDRESS as base.
 *
 * @param string $link
 *
 * @return string
 */
function create_internal_link(string $link = ''): string
{
    global $SERVER_ADDRESS;
    return $SERVER_ADDRESS . $link;
}


/**
 * Get env variable.
 *
 * @param string $key
 * @param string $default
 *
 * @return string
 */
function get_env(string $key, string $default = ''): string
{
    return $_ENV[$key] ?? $default;
}

/**
 * Get random token.
 *
 * @return string
 */
function get_random_token(): string
{
    return md5(uniqid((string)mt_rand(), TRUE));
}