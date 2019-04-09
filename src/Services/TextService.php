<?php

declare(strict_types=1);

namespace Dogsy\Services;


use Dogsy\Entities\Text;
use Dogsy\Entities\User;
use Dogsy\Helpers\FileHelper;
use Dogsy\Repositories\TextRepository;
use Dogsy\Repositories\UserRepository;

/**
 * Class TextService
 * @package Dogsy\Services
 */
class TextService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;
    /**
     * @var TextRepository
     */
    protected $textRepository;

    /**
     * TextService constructor.
     * @param UserRepository $userRepository
     * @param TextRepository $textRepository
     */
    public function __construct(UserRepository $userRepository, TextRepository $textRepository)
    {
        $this->userRepository = $userRepository;
        $this->textRepository = $textRepository;
    }

    /**
     * For each user, calculate the average number of lines in his text files
     * @return array
     */
    public function countAverageLineCount()
    {
        $result = [];
        $users = $this->userRepository->get();
        /** @var User $user */
        foreach ($users as $user) {
            $countLines = [];
            $avgCountLists = 0;

            /** @var Text $text */
            foreach ($user->getTexts() as $text) {
                $countLines [] = substr_count($text->getText(), PHP_EOL);
            }
            if (count($countLines) !== 0) {
                $avgCountLists = round(array_sum($countLines) / count($countLines), 2);
            }

            $result[$user->getId()] = [
                'name' => $user->getName(),
                'count' => $avgCountLists
            ];
        }
        return $result;
    }


    /**
     * Put texts of f the users to folder, replacing in each text dates in format dd/mm/yy to format mm-dd-yyyy
     * @return array
     */
    public function replaceDates(): array
    {
        $result = [];
        $users = $this->userRepository->get();
        /** @var User $user */
        foreach ($users as $user) {
            $count = 0;
            /** @var Text $text */
            foreach ($user->getTexts() as $text) {
                $re = '/\d{2}\/\d{2}\/\d{2}/m';
                preg_match_all($re, $text->getText(), $matches, PREG_SET_ORDER, 0);

                foreach ($matches as $match) {
                    $data = $match[0];
                    $dataArray = explode('/', $data);
                    $day = $dataArray[0];
                    $month = $dataArray[1];
                    $year = $dataArray[2] > 19 ? '19' . $dataArray[2] : '20' . $dataArray[2];
                    $newData = sprintf('%s-%s-%s', $month, $day, $year);

                    $text->setText(str_replace($data, $newData, $text->getText()));
                }

                FileHelper::prepareFolder(getenv('RESULT_PATH'));
                FileHelper::writeFile(getenv('RESULT_PATH') . '/' . $text->getFileName(), $text->getText());

                $count += count($matches);
            }
            $result[$user->getId()] = [
                'name' => $user->getName(),
                'count' => $count
            ];
        }
        return $result;

    }
}