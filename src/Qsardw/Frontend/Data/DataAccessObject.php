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

use \Doctrine\DBAL\Connection;

/**
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
 */
class DataAccessObject
{
    /**
     * Database connection object
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;

    /**
     * Stores the table name
     * @var string
     */
    protected $table;

    public function __construct(Connection $connection, $table)
    {
        $this->setConnection($connection);
        $this->setTable($table);
    }

    /**
     * Returns the database connection object
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Returns the name of the table to be used in the DAO
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Sets the database connection object
     * @param \Doctrine\DBAL\Connection $connection
     * @return \Qsardw\Frontend\Data\DataAccessObject
     */
    public function setConnection(\Doctrine\DBAL\Connection $connection)
    {
        $this->connection = $connection;
        return $this;
    }

    /**
     * Sets the name of the table to be used in the DAO
     * @param string $table
     * @return \Qsardw\Frontend\Data\DataAccessObject
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }
    
    /**
     * Executes an insert into the database
     *
     * @param array $insertData
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Exception
     */
    public function executeInsert(array $insertData)
    {
        $this->connection->beginTransaction();
        try {
            $this->connection->insert($this->table, $insertData);
            $this->connection->commit();
        } catch (\Exception $exception) {
            $this->connection->rollback();
            throw $exception;
        }
    }

    /**
     * Executes an prepared statement
     *
     * @param string $sql
     * @param array $params
     * @return boolean
     * @throws Exceptions\QueryExecutionError
     */
    protected function executeQuery($sql, array $params = array())
    {
        $sqlStatement = $this->connection->prepare($sql);
        foreach ($params as $paramName => $paramValue) {
            $sqlStatement->bindValue($paramName, $paramValue);
        }

        $result = $sqlStatement->execute();
        if ($result !== false) {
            return true;
        } else {
            throw new Exceptions\QueryExecutionError($sql);
        }
    }

    protected function executeQueryAndReturnAffectedRows($sql, array $params = array())
    {
        $sqlStatement = $this->connection->prepare($sql);
        foreach ($params as $paramName => $paramValue) {
            $sqlStatement->bindValue($paramName, $paramValue);
        }

        $result = $sqlStatement->execute();
        if ($result !== false) {
            return $sqlStatement->rowCount();
        } else {
            throw new Exceptions\QueryExecutionError($sql);
        }
    }
    
    protected function executeQueryAndReturnResults($sql, array $params = array())
    {
        $sqlStatement = $this->connection->prepare($sql);
        foreach ($params as $paramName => $paramValue) {
            $sqlStatement->bindValue($paramName, $paramValue);
        }

        $result = $sqlStatement->execute();
        if ($result !== false) {
            return $sqlStatement->fetchAll();
        } else {
            throw new Exceptions\QueryExecutionError($sql);
        }
    }

    protected function executeQueryAndReturnRow($sql, array $params = array())
    {
        $sqlStatement = $this->connection->prepare($sql);
        foreach ($params as $paramName => $paramValue) {
            $sqlStatement->bindValue($paramName, $paramValue);
        }

        $result = $sqlStatement->execute();
        if ($result !== false) {
            return $sqlStatement->fetch();
        } else {
            throw new Exceptions\QueryExecutionError($sql);
        }
    }

    /**
     * Executes an insert into the database
     *
     * @param array $updateData
     * @param $id
     * @return int
     * @throws Exception
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Exception
     */
    public function executeUpdate(array $updateData, $id)
    {
        $this->connection->beginTransaction();
        try {
            $primaryKey = ['id' => $id];
            $rows = $this->connection->update($this->table, $updateData, $primaryKey);
            $this->connection->commit();

            return $rows;
        } catch (\Exception $exception) {
            $this->connection->rollback();
            throw $exception;
        }
    }
}
