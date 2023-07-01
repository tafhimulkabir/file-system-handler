<?php
/**
 * File System Handler
 *
 * This PHP class fetches files and folders recursively.
 */

declare(strict_types=1);

namespace App\Utility;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'helper.php';

class FileSystemHandler
{
    private string $dirPath;

    public function fetch(string $path, string $type = 'both', bool $recursion = false): void
    {
        $path = realpath(trim($path));

        $this->validatePath($path);

        $this->process($path, $type, $recursion);
    }

    private function validatePath(string $path): void
    {
        if ($path === false) {
            throw new \InvalidArgumentException('No directory found at: ' . $path);
        }
        if (!is_dir($path)) {
            throw new \InvalidArgumentException('Invalid directory: ' . $path);
        }
        if (!is_file_path($path)) {
            throw new \InvalidArgumentException('Invalid path: ' . $path);
        }
    }

    private function process(string $path, string $type, bool $recursion): void
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $filename = $item->getFilename();
            $filepath = $item->getPathname();

            if ($type === 'both' || ($type === 'dir' && $item->isDir()) || ($type === 'file' && $item->isFile())) {
                echo 'Filename: ' . $filename . PHP_EOL;
                echo 'Filepath: ' . $filepath . PHP_EOL;
                echo '--------------------------' . PHP_EOL;
            }

            if ($recursion === false && $item->isDir()) {
                $iterator->setMaxDepth(0);
            }
        }
    }
}

$file = new FileSystemHandler();
$file->fetch('..');
