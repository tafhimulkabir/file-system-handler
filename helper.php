<?php

/**
 * FileSystemHandler Helper
 *
 * This file holds all the helper functions for the FileSystemHandler class.
 */

declare(strict_types = 1);

/**
 * Check if a path is a valid file path.
 *
 * @param string $path The path to validate.
 *
 * @return bool True if the path is valid, false otherwise.
 */
function is_file_path(string $path): bool
{
    $separator = preg_quote(DIRECTORY_SEPARATOR, '/');
    $regex = '/^([a-zA-Z]:)?(' . $separator . '[a-zA-Z0-9\s_@\-^!#$%&+={}\[\].]+)*$/';
    return preg_match($regex, $path) === 1;
}
