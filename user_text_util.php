<?php
require 'vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::create(__DIR__, '.env');
$dotenv->overload();

if ($argv[1] === 'comma') {
    $separator = ',';
} else {
    $separator = ';';
}

if ($argv[2] === 'seed') {
    (new \Dogsy\Seeder($separator))->run();
}

if ($argv[2] === 'countAverageLineCount') {
    $items = (new \Dogsy\Services\TextService(
        new \Dogsy\Repositories\FileUserRepository($separator),
        new \Dogsy\Repositories\FileTextRepository())
    )
        ->countAverageLineCount();
    echo 'ID Name AvgLineCount' . PHP_EOL;
    foreach ($items as $item) {
        echo $item['name'] . ': ' . $item['count'] . PHP_EOL;

    }
}

if ($argv[2] === 'replaceDates') {
    $items = (new \Dogsy\Services\TextService(
        new \Dogsy\Repositories\FileUserRepository($separator),
        new \Dogsy\Repositories\FileTextRepository())
    )
        ->replaceDates();
    echo 'Name Replaces count' . PHP_EOL;
    foreach ($items as $item) {
        echo $item['name'] . ': ' . $item['count'] . PHP_EOL;

    }
}

