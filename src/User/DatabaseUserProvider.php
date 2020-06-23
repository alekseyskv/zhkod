<?php


namespace App\User;


use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class DatabaseUserProvider implements UserProviderInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    private function getUser($username)
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('*')
            ->from('users')
            ->where('username = :username')
            ->setParameter('username', $username);
        $stmt = $qb->execute();
        $row = $stmt->fetch();

        if (!$row['username'])
        {
            $e = new UsernameNotFoundException(sprintf('Username "%s" not found in the database.', $username));
            $e->setUsername($username);
            throw $e;
        }
        else
        {
            return new User(
                $row['username'],
                $row['password'],
                [$row['role']]
            );
        }
    }
    /**
     * @inheritDoc
     */
    function loadUserByUsername($username)
    {
        return $this->getUser($username);
    }

    /**
     * @inheritDoc
     */
    function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User)
        {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->getUser($user->getUsername());
    }

    /**
     * @inheritDoc
     */
    function supportsClass($class)
    {
        //return 'App\User\User' === $class;
        return 'Symfony\Component\Security\Core\User\User' === $class;
    }
}