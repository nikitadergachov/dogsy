<?php

declare(strict_types=1);

namespace Dogsy\Repositories;


use Dogsy\Exceptions\CreateModelException;
use Dogsy\Factories\UserFactory;
use Dogsy\Helpers\FileHelper;
use RecursiveDirectoryIterator;

/**
 * Class FileUserRepository
 * @package Dogsy\Repositories
 */
class FileUserRepository implements UserRepository
{
    private $userFactory;
    private $separator;

    public function __construct($separator)
    {
        $this->userFactory = new UserFactory();
        $this->separator = $separator;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $items = FileHelper::readFileCvs(getenv('USERS_FILE_PATH'), $this->separator);
        $modelCollection = [];
        foreach ($items as $item) {
            try {
                $modelCollection [] = $this->userFactory->create($item);
            } catch (CreateModelException $exception) {
                echo $exception->getMessage() . PHP_EOL;
            }
        }
        return $modelCollection;
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getByUserId(int $userId): array
    {
        $iterator = new RecursiveDirectoryIterator(getenv('TEXTS_FOLDER_PATH'), $this->separator);
        $iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);

        $texts = [];
        foreach ($iterator as $file) {
            if (preg_match_all(sprintf("/^%s_\d{1,4}.txt/m", $userId), $file->getFilename())) {
                $texts = FileHelper::readFile($file->getRealPath());
            }
        }
        return $texts;
    }
}