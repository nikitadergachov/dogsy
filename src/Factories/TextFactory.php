<?php

namespace Dogsy\Factories;


use Dogsy\Entity\AbstractEntity;
use Dogsy\Entity\Text;
use Dogsy\Exceptions\CreateModelException;

/**
 * Class TextFactory
 * @package Dogsy\Factories
 */
class TextFactory implements Factory
{
    /**
     * Create Text entity by values
     * @param array $fields
     * @return Text
     * @throws CreateModelException
     */
    function create(array $fields): AbstractEntity
    {
        $text = new Text();
        $filledFields = 0;
        if(isset($fields[0])) {
            $text->setFileName($fields[0]);
            $filledFields++;
        }
        if(isset($fields[1])) {
            $text->setText($fields[1]);
            $filledFields++;
        }
        if($filledFields !== 2) {
            throw new CreateModelException($text);
        }
        return $text;
    }
}