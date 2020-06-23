<?php


namespace App\User;


use Symfony\Component\Security\Core\User\Role;
use Symfony\Component\Security\Core\User\UserInterface;

class MyUser implements UserInterface
{
    private $username;
    private $password;
    private $status;
    private $roles = [];

    public function __construct(string $username, string $password)
    {
        if (empty($username)) {
            throw new \InvalidArgumentException('No username provided.');
        }
        $this->username = $username;
        $this->password = $password;
    }


    /**
     * @inheritDoc
     */
    function getRoles()
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @inheritDoc
     */
    function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    function getSalt()
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @inheritDoc
     */
    function equals(UserInterface $user)
    {
        // TODO: Implement equals() method.
    }
}