<?php

namespace Qsardw\Frontend\Data;

use Doctrine\DBAL\Connection;

/**
 * Description of DatasetProcessedMolecules
 *
 * @author Javier Caride Ulloa <javier.caride@gmail.com>
 */
class DatasetRawMolecules extends DataAccessObject
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection, 'dataset_raw_molecules');
    }
    
    /**
     * Return the dataset count of the different status of the molecules
     *
     * @param int $dataset
     * @return array
     */
    public function getStatusCount($dataset)
    {
        $sql = "SELECT count(*) AS 'num_molecules', status "
            . "FROM  dataset_raw_molecules "
            . "WHERE dataset = :dataset "
            . "GROUP BY dataset , status;";
        
        $params = array(
            'dataset' => $dataset
        );
        
        return $this->executeQueryAndReturnResults($sql, $params);
    }
}
