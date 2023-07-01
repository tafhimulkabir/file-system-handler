<?php
/**
 * File System Handler
 *
 * This PHP class fetch files and folders recursively
 */
declare(strict_types = 1);

namespace App\Utility;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'helper.php';

class FileSystemHandler
{
    private const BASE_PATH = __DIR__ . DIRECTORY_SEPARATOR;
    private string $dirPath;

    public function fetch(string $path, string $type = 'both', bool $recursion = false): array
    {
        $this->validatePath($path);
        return [];
    }

    private function validatePath(string $path): string
    {
        $path = realpath(trim($path));
        if ($path !== false && is_dir($path) && is_file_path($path)) {
            return $path;
        } else {
            throw new \InvalidArgumentException('Invalid Path : ' . $path);
        }
    }
}
