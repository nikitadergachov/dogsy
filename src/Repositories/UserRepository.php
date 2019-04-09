<?php

declare(strict_types=1);

namespace Dogsy\Repositories;


interface UserRepository
{
    public function get(): array;

    public function getByUserId(int $userId): array;
}