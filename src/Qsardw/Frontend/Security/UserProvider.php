<?php
/*
 * This file is part of the QSARDW Frontend project
 *
 * (c) Javier Caride Ulloa <javier.caride@qsardw.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Qsardw\Frontend\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Doctrine\DBAL\Connection;

/**
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
 */
class UserProvider implements UserProviderInterface
{
    private $databaseConnection;

    public function __construct(Connection $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }

    /**
     * Searches an user in the database using the username as filter
     *
     * @param string $username
     * @return \Symfony\Component\Security\Core\User\User
     * @throws UsernameNotFoundException
     */
    public function loadUserByUsername($username)
    {
        $userQuery = "SELECT * FROM users WHERE username = ?";
        $statement = $this->databaseConnection->executeQuery($userQuery, array(strtolower($username)));

        if (!$user = $statement->fetch()) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
        
        $roles = array($user['rol']);
        $user = new User(
            $user['id'],
            $user['username'],
            $user['password'],
            $roles,
            true,
            true,
            true, true
        );
        
        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (($user instanceof User) === false) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Qsardw\Frontend\Security\User';
    }
}
