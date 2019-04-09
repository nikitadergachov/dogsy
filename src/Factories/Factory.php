<?php

declare(strict_types=1);

namespace Dogsy\Factories;


use Dogsy\Entities\AbstractEntity;

interface Factory
{
    function create(array $fields): AbstractEntity;
}