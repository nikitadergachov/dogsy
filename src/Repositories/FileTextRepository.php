<?php

declare(strict_types=1);

namespace Dogsy\Repositories;


use Dogsy\Entity\Text;
use Dogsy\Exceptions\CreateModelException;
use Dogsy\Factories\TextFactory;
use Dogsy\Helpers\FileHelper;
use RecursiveDirectoryIterator;

/**
 * Class FileTextRepository
 * @package Dogsy\Repositories
 */
class FileTextRepository implements TextRepository
{
    /**
     * @var TextFactory
     */
    private $textFactory;

    public function __construct()
    {
        $this->textFactory = new TextFactory();
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $iterator = new RecursiveDirectoryIterator(getenv('TEXTS_FOLDER_PATH'));
        $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
        $textCollection = [];
        foreach ($iterator as $file) {
            $textCollection [] = $this->getTextFromFile($file);
        }
        return $textCollection;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getByUserId(int $userId): array
    {
        $iterator = new RecursiveDirectoryIterator(getenv('TEXTS_FOLDER_PATH'));
        $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
        $textCollection = [];
        foreach ($iterator as $file) {
            if (preg_match_all(sprintf("/^%s_\d{1,4}.txt/m", $userId), $file->getFilename())) {
                $textCollection [] = $this->getTextFromFile($file);
            }
        }
        return $textCollection;
    }

    /**
     * @param \SplFileInfo $file
     * @return Text
     */
    private function getTextFromFile(\SplFileInfo $file): Text
    {
        $textModel = null;
        $text = FileHelper::readFile($file->getRealPath());
        try {
            $textModel = $this->textFactory->create([$file->getFilename(), $text]);
        } catch (CreateModelException $e) {
            echo $e->getMessage();
        }
        return $textModel;
    }
}