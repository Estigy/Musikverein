<?php

namespace Application\Entity;

use Application\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="lt_users")
*/
class User extends Entity
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue
    *
    * @var integer
    */
	protected $id;

    /**
    * @ORM\Column(name="date_creation", type="date")
    *
    * @var DateTime
    */
    protected $creationDate;

    /**
    * @ORM\Column(name="firstname")
    *
    * @var string
    */
    protected $firstname;

    /**
    * @ORM\Column(name="lastname")
    *
    * @var string
    */
    protected $lastname;

    /**
    * @ORM\Column(name="username")
    *
    * @var string
    */
    protected $username;

    /**
    * @ORM\Column(name="password")
    *
    * @var string
    */
    protected $password;

    /**
    * @ORM\Column(name="roles", type="json_array", nullable=true)
    *
    * @var string
    */
    protected $roles;

    public static function checkHashedPassword($entity, $password)
    {
        return $entity->password == md5($password);
    }
}