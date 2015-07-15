<?php

namespace Qsardw\Frontend\Data;

use Doctrine\DBAL\Connection;

/**
 * Description of Users
 *
 * @author Javier Caride Ulloa <javier.caride@gmail.com>
 */
class Users extends DataAccessObject
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection, 'users');
    }

    public function getUser($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $params = array(
            'id' => $id
        );

        return $this->executeQueryAndReturnRow($sql, $params);
    }
}
