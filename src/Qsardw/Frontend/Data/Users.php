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

    /**
     * Retrieves the user bean by its id
     *
     * @param $id
     * @return mixed
     * @throws Exceptions\QueryExecutionError
     */
    public function getUser($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $params = array(
            'id' => $id
        );

        return $this->executeQueryAndReturnRow($sql, $params);
    }

    /**
     * Updates the user bean
     *
     * @param array $params
     * @return bool
     * @throws Exceptions\QueryExecutionError
     */
    public function updateUser(array $params)
    {
        $id = $params['id'];
        unset($params['id']);

        return $this->executeUpdate($params, $id);
    }
}
