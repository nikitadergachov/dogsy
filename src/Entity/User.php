<?php

declare(strict_types=1);

namespace Dogsy\Entity;


use Dogsy\Repositories\FileTextRepository;

class User extends AbstractEntity
{
    private $id;
    private $name;
    private $lastName;
    private $texts;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getTexts()
    {
        return (new FileTextRepository())->getByUserId($this->getId());
    }

    /**
     * @param mixed $texts
     */
    public function setTexts(array $texts): void
    {
        $this->texts = $texts;
    }
}