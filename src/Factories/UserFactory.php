<?php

declare(strict_types=1);

namespace Dogsy\Factories;


use Dogsy\Exceptions\CreateModelException;
use Dogsy\Entity\AbstractEntity;
use Dogsy\Entity\User;

/**
 * Class UserFactory
 * @package Dogsy\Factories
 */
class UserFactory implements Factory
{
    /**
     * Create User entity by values
     * @param array $fields
     * @return User
     * @throws CreateModelException
     */
    function create(array $fields): AbstractEntity
    {
        $user = new User();
        $filledFields = 0;
        if (isset($fields[0]) && is_numeric($fields[0])) {
            $user->setId((int)$fields[0]);
            $filledFields++;
        }
        if (isset($fields[1])) {
            $name = explode(' ', $fields[1]);
            if (isset($name[0])) {
                $user->setName($name[0]);
                $filledFields++;
            }
            if (isset($name[1])) {

                $user->setLastName($name[1]);
                $filledFields++;
            }
        }
        if ($filledFields !== 3) {
            throw new CreateModelException($user);
        }
        return $user;
    }
}