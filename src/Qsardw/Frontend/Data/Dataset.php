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

use Qsardw\Frontend\Data\Datasets\Statuses;
use Doctrine\DBAL\Connection;

/**
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
 */
class Dataset extends DataAccessObject
{
    public function __construct(Connection $connection)
    {
        parent::__construct($connection, 'dataset');
    }

    /**
     * List all datasets that belongs to an user
     * @param int $owner
     * @return array
     */
    public function listByOwner($owner)
    {
        $sql = "SELECT dt.*,u.complete_name AS 'owner_name' FROM dataset dt, users u
            WHERE dt.owner = :owner AND u.id = dt.owner
          UNION
          SELECT dt.*,u.complete_name AS 'owner_name' FROM dataset dt, users u
            WHERE dt.visibility = 2 AND dt.owner <> :owner AND u.id = dt.owner AND u.user_group = 1
          UNION
          SELECT dt.*,u.complete_name AS 'owner_name' FROM dataset dt, users u
          WHERE dt.visibility = 3 AND dt.owner <> :owner AND u.id = dt.owner;";

        $params = array(
            'owner' => $owner
        );

        return $this->executeQueryAndReturnResults($sql, $params);
    }
    
    /**
     * Saves a dataset
     *
     * @param array $datasetData
     */
    public function save(array $datasetData)
    {
        if (array_key_exists('id', $datasetData)) {
            unset($datasetData['id']);
        }
        
        $this->executeInsert($datasetData);
    }
    
    public function delete($datasetId)
    {
        $sql = "DELETE FROM {$this->getTable()} WHERE id = :datasetId LIMIT 1";
        $params = array(
            'datasetId' => $datasetId
        );
        
        return $this->executeQueryAndReturnAffectedRows($sql, $params);
    }
    
    /**
     * Reads the dataset with the given primary key
     *
     * @param type $datasetId
     * @return \Qsardw\Frontend\Data\Beans\Dataset
     */
    public function read($datasetId)
    {
        $sql = "SELECT * FROM {$this->getTable()} WHERE id = :datasetId";
        $params = array(
            'datasetId' => $datasetId
        );
        
        $row = $this->executeQueryAndReturnRow($sql, $params);
        $datasetBean = new Beans\Dataset();
        $datasetBean->fromRow($row);
        
        return $datasetBean;
    }

    /**
     * Returns pending datasets count
     * @param int $owner
     * @return int
     */
    public function countPendingByOwner($owner)
    {
        return $this->countByOwnerFilteringByStatus($owner, Statuses::PENDING);
    }

    /**
     * Returns clean datasets count
     * @param int $owner
     * @return int
     */
    public function countCleanByOwner($owner)
    {
        return $this->countByOwnerFilteringByStatus($owner, Statuses::CLEAN);
    }

    /**
     * Returns datasets count in cleaning status
     * @param int $owner
     * @return int
     */
    public function countCleaningByOwner($owner)
    {
        return $this->countByOwnerFilteringByStatus($owner, Statuses::CLEANING);
    }

    /**
     * Returns datasets count in error status
     * @param int $owner
     * @return int
     */
    public function countErrorsByOwner($owner)
    {
        return $this->countByOwnerFilteringByStatus($owner, Statuses::ERROR);
    }

    /**
     * Counts owner datasets filtering by the desired status
     * @param int $owner
     * @param int $status
     * @return int
     */
    protected function countByOwnerFilteringByStatus($owner, $status)
    {
        $sql = "SELECT COUNT(id) AS 'datasets' FROM {$this->getTable()} "
            . "WHERE owner = :owner AND status = :status";

        $params = array(
            'owner' => $owner,
            'status' => $status
        );

        $result = $this->executeQueryAndReturnRow($sql, $params);

        return intval($result['datasets']);
    }
}
