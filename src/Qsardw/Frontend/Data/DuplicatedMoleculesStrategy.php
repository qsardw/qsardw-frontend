<?php

namespace Qsardw\Frontend\Data;

use \Doctrine\DBAL\Connection;

/**
 * Description of DuplicatedMoleculesStrategy
 *
 * @author Javier Caride Ulloa <javier.caride@gmail.com>
 */
class DuplicatedMoleculesStrategy extends DataAccessObject
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection, 'duplicated_molecules_strategy');
    }
    
    public function listAll()
    {
        $sql = "SELECT * FROM {$this->getTable()} ORDER BY id ASC";
        return $this->executeQueryAndReturnResults($sql);
    }
}
