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
class DatasetProcessedMolecules extends DataAccessObject
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection, 'dataset_processed_molecules');
    }
    
    /**
     * Return the dataset count of the different status of the molecules
     *
     * @param int $dataset
     * @return array
     */
    public function getStatusCount($dataset)
    {
        $sql = "SELECT count(*) AS 'num_molecules', processed_status "
            . "FROM  dataset_processed_molecules "
            . "WHERE dataset = :dataset "
            . "GROUP BY dataset , processed_status;";
        
        $params = array(
            'dataset' => $dataset
        );
        
        return $this->executeQueryAndReturnResults($sql, $params);
    }
}
