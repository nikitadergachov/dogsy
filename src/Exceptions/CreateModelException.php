<?php

declare(strict_types=1);

namespace Dogsy\Exceptions;


use Dogsy\Entity\AbstractEntity;
use Exception;

class CreateModelException extends Exception
{

    public function __construct(AbstractEntity $model)
    {
        parent::__construct('Error create model: ' . get_class($model));
    }
}