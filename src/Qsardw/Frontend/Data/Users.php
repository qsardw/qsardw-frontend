<?php
/*
 * This file is part of the QSARDW Frontend project
 *
 * (c) Javier Caride Ulloa <javier.caride@qsardw.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Qsardw\Frontend\Data;

use Doctrine\DBAL\Connection;

/**
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
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
