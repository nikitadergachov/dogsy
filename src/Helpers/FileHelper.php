<?php
declare(strict_types=1);

namespace Dogsy\Helpers;


use RecursiveDirectoryIterator;

class FileHelper
{
    public static function readFileCvs(string $filePath, $separator = ',')
    {

        $handle = fopen($filePath, 'r');
        $items = [];
        while (($data = fgetcsv($handle, 1000, $separator)) !== false) {
            $items [] = $data;
        }
        fclose($handle);
        return $items;
    }

    public static function readFile(string $filePath): string
    {
        if (is_file($filePath)) {
            return file_get_contents($filePath);
        }
        return '';
    }

    public static function writeFile(string $filePath, string $content): void
    {
        $handle = fopen($filePath, 'w');
        fputs($handle, $content);
        fclose($handle);
    }

    public static function writeCsv(string $filePath, array $items, string $separator = ','): void
    {
        $handle = fopen($filePath, 'w');
        foreach ($items as $item) {
            fputs($handle, implode($item, $separator) . PHP_EOL);
        }
        fclose($handle);
    }

    public static function prepareFolder($folderPath): void
    {
        if (is_dir($folderPath)) {
            self::clearFolder($folderPath);
        } else {
            mkdir($folderPath);
        }
    }

    private static function clearFolder($folderPath): void
    {
        $iterator = new RecursiveDirectoryIterator($folderPath);
        $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
        foreach ($iterator as $file) {
            if (is_file($file->getRealPath())) {
                unlink($file->getRealPath());
            }
        }
    }
}