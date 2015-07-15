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
