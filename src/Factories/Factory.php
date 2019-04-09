<?php

declare(strict_types=1);

namespace Dogsy\Factories;


use Dogsy\Entity\AbstractEntity;

interface Factory
{
    function create(array $fields): AbstractEntity;
}