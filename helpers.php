<?php
/**
 * Escape all html characters.
 * @param string|null $string $string
 * @return string
 */
function clean_string(string|null $string): string
{
    if ($string == null) {
        return '';
    }
    return htmlspecialchars($string, ENT_QUOTES);
}

/**
 * Get value from global $_GET variable.
 * @param string $key
 * @return string
 */
function get_value(string $key): string
{
    if ($key != null && isset($_GET[$key])) {
        return clean_string($_GET[$key]);
    }
    return '';
}