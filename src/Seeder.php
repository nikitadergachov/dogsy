<?php

declare(strict_types=1);

namespace Dogsy;


use Dogsy\Helpers\FileHelper;

class Seeder
{
    private $separator;

    private $names = [
        'Boris',
        'Viktor',
        'Gennady',
        'Dmitry',
        'Nikita',
        'Andrey',
        'Oleg'
    ];

    private $lastNames = [
        'Aleksandrov',
        'Terentyev',
        'Tikhonov',
        'Shishkin',
        'Zaytsev',
        'Dergachov',
        'Anisimov'
    ];

    private $words = [
        'cat',
        'dog',
        'claim',
        'apple',
        'fortress',
        'agape',
        'anchor',
        'figure',
        'division',
        'ferry',
        'bundle',
        'droplet'
    ];

    public function __construct($separator)
    {

        $this->separator = $separator;
    }

    public function run(): void
    {
        $usersData = [];
        for ($i = 0; $i < 50; $i++) {
            $name = $this->names[array_rand($this->names)];
            $lastName = $this->lastNames[array_rand($this->lastNames)];
            $id = $i + 1;
            $usersData [] = [$id, $name . ' ' . $lastName];
        }
        FileHelper::writeCsv(getenv('USERS_FILE_PATH'), $usersData, $this->separator);

        FileHelper::prepareFolder(getenv('TEXTS_FOLDER_PATH'));

        foreach ($usersData as $userData) {
            $countFiles = mt_rand(5, 20);
            for ($i = 0; $i < $countFiles; $i++) {
                $filePath = getenv('TEXTS_FOLDER_PATH') . '/' . $this->getFileName($userData[0]);
                FileHelper::writeFile($filePath, $this->getRandomText());
            }
        }
    }


    private function getFileName(int $userId)
    {
        $length = mt_rand(1, 4);
        $fileNumberWithZeros = '';

        switch ($length) {
            case 1:
                $fileNumber = (string)mt_rand(1, 9);
                $fileNumberWithZeros = str_repeat('0', mt_rand(0, 3)) . (string)$fileNumber;
                break;
            case 2:
                $fileNumber = (string)mt_rand(1, 9) . (string)mt_rand(0, 9);
                $fileNumberWithZeros = str_repeat('0', mt_rand(0, 2)) . (string)$fileNumber;
                break;
            case 3:
                $fileNumber = (string)mt_rand(1, 9) . (string)mt_rand(1, 9) . (string)mt_rand(0, 9);
                $fileNumberWithZeros = str_repeat('0', mt_rand(0, 1)) . (string)$fileNumber;
                break;
            case 4:
                $fileNumber = (string)mt_rand(1, 9) . (string)mt_rand(1, 9) . (string)mt_rand(1, 9) . (string)mt_rand(0, 9);
                $fileNumberWithZeros = $fileNumber;
                break;
        }
        return $userId . '_' . $fileNumberWithZeros . '.txt';
    }


    private function getRandomText(): string
    {
        $count = mt_rand(1, 500);
        $text = '';

        for ($i = 0; $i < $count; $i++) {
            $text .= $this->words[array_rand($this->words)];
            $text .= ' ';
            if (mt_rand(0, 1) === 1) {
                $data = rand(1262055681, 1562055681);
                $dataFormat = date('d/m/y', $data);
                $text .= $dataFormat;
                $text .= ' ';
            } else {
                $text .= PHP_EOL;
            }
        }
        return $text;
    }
}