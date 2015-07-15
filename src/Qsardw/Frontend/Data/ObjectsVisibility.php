<?php

namespace Qsardw\Frontend\Data;

use \Doctrine\DBAL\Connection;

/**
 * Description of newPHPClass
 *
 * @author Javier Caride Ulloa <javier.caride@gmail.com>
 */
class ObjectsVisibility extends DataAccessObject
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection, 'objects_visibility');
    }
    
    public function listAll()
    {
        $sql = "SELECT * FROM {$this->getTable()} ORDER BY id ASC";
        return $this->executeQueryAndReturnResults($sql);
    }
}
