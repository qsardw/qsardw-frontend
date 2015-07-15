<?php

namespace Qsardw\Frontend\ApiClient;

/**
 * Description of DatasetMolecules
 *
 * @author Javier Caride Ulloa <javier.caride@gmail.com>
 */
class DatasetMolecules extends QsardwApiClient
{
    public function __construct($host = 'localhost', $port = '8080')
    {
        parent::__construct($host, $port);
    }
    
    public function getDatasetCleanMolecules($dataset, $limit = null, $offset = null)
    {
        $url = $this->getBaseEndpoint() . "dataset/{$dataset}/cleanmolecules";
        return $this->callAndGetCollection($url, $limit, $offset);
    }
    
    public function getDatasetDiscardedMolecules($dataset, $limit = null, $offset = null)
    {
        $url = $this->getBaseEndpoint() . "dataset/{$dataset}/discardedmolecules";
        return $this->callAndGetCollection($url, $limit, $offset);
    }
    
    public function getDatasetMoleculesToReview($dataset, $limit = null, $offset = null)
    {
        $url = $this->getBaseEndpoint() . "dataset/{$dataset}/moleculestoreview";
        return $this->callAndGetCollection($url, $limit, $offset);
    }
    
    public function getDatasetInchiKeyDuplicates($dataset, $inchiKey, $limit = null, $offset = null)
    {
        $url = $this->getBaseEndpoint() . "dataset/{$dataset}/duplicates/{$inchiKey}";
        return $this->callAndGetCollection($url, $limit, $offset);
    }
    
    public function getDatasetGroups($dataset, $limit = null, $offset = null)
    {
        $url = $this->getBaseEndpoint() . "dataset/{$dataset}/groups";
        return $this->callAndGetCollection($url, $limit, $offset);
    }
    
    public function getDatasetGroupMolecules($dataset, $group, $limit = null, $offset = null)
    {
        $url = $this->getBaseEndpoint() . "dataset/{$dataset}/multiples/{$group}";
        return $this->callAndGetCollection($url, $limit, $offset);
    }
    
    public function cleanDatasetMolecule($moleculeId)
    {
        $url = $this->getBaseEndpoint() . "molecule/{$moleculeId}/clean";
        return $this->update($url);
    }
    
    public function getSdfFile($dataset)
    {
        $url = $this->getBaseEndpoint() . "datasets/{$dataset}/sdf";
        return $this->callAndGetCollection($url);
    }
}
