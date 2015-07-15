<?php
/*
 * This file is part of the QSARDW Frontend project
 *
 * (c) Javier Caride Ulloa <javier.caride@qsardw.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Qsardw\Frontend\Data\Beans;

use Qsardw\Frontend\Traits\BeanSerializer;
use Qsardw\Frontend\Traits\BeanUnserializer;

/**
 * Bean for dataset table
 *
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
 */
class Dataset
{
    use BeanSerializer, BeanUnserializer;
    
    /**
     * Unique dataset identifier
     * @var integer
     */
    protected $id;
    
    /**
     * Dataset name
     * @var string
     */
    protected $datasetName;
    
    /**
     * Dataset description
     * @var string
     */
    protected $description;

    /**
     * Original file path
     * @var string
     */
    protected $originalFile;
    
    /**
     * File type
     * @var int
     */
    protected $fileType;
    
    /**
     * Number of initial molecules
     * @var int
     */
    protected $initialMolecules;
    
    /**
     * Number of distinct molecules
     * @var int
     */
    protected $distinctMolecules;
    
    /**
     * Flag to know if the cleaning process has been executed to the dataset
     * @var int
     */
    protected $isCleaned;
    
    /**
     * Identifier of the dataset owner
     * @var int
     */
    protected $owner;
    
    /**
     * Date of dataset creation
     * @var \DateTime
     */
    protected $createdOn;
    
    /**
     * ID of the strategy if multiple molecules found in a dataset position
     * @var int
     */
    protected $multipleMoleculesStrategy;
    
    /**
     * ID of the strategy if duplicates found
     * @var int
     */
    protected $onDuplicatesStrategy;
    
    /**
     * Status of the dataset
     * @var int
     */
    protected $status;
    
    /**
     * Visibility of the dataset
     * @var int
     */
    protected $visibility;
    
    /**
     * Timestamp of the last dataset update
     *
     * @var \DateTime
     */
    protected $ts;
    
    public function getId()
    {
        return $this->id;
    }

    public function getDatasetName()
    {
        return $this->datasetName;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getOriginalFile()
    {
        return $this->originalFile;
    }

    public function getFileType()
    {
        return $this->fileType;
    }

    public function getInitialMolecules()
    {
        return $this->initialMolecules;
    }

    public function getDistinctMolecules()
    {
        return $this->distinctMolecules;
    }

    public function getIsCleaned()
    {
        return $this->isCleaned;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function getMultipleMoleculesStrategy()
    {
        return $this->multipleMoleculesStrategy;
    }

    public function getOnDuplicatesStrategy()
    {
        return $this->onDuplicatesStrategy;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getVisibility()
    {
        return $this->visibility;
    }

    public function getTs()
    {
        return $this->ts;
    }

    public function setId($id)
    {
        $this->id = intval($id);
        return $this;
    }

    public function setDatasetName($datasetName)
    {
        $this->datasetName = $datasetName;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setOriginalFile($originalFile)
    {
        $this->originalFile = $originalFile;
        return $this;
    }

    public function setFileType($fileType)
    {
        $this->fileType = intval($fileType);
        return $this;
    }

    public function setInitialMolecules($initialMolecules)
    {
        $this->initialMolecules = intval($initialMolecules);
        return $this;
    }

    public function setDistinctMolecules($distinctMolecules)
    {
        $this->distinctMolecules = intval($distinctMolecules);
        return $this;
    }

    public function setIsCleaned($isCleaned)
    {
        $this->isCleaned = $isCleaned;
        return $this;
    }

    public function setOwner($owner)
    {
        $this->owner = intval($owner);
        return $this;
    }

    public function setCreatedOn($createdOn)
    {
        $this->createdOn = new \DateTime($createdOn);
        return $this;
    }

    public function setMultipleMoleculesStrategy($multipleMoleculesStrategy)
    {
        $this->multipleMoleculesStrategy = intval($multipleMoleculesStrategy);
        return $this;
    }

    public function setOnDuplicatesStrategy($onDuplicatesStrategy)
    {
        $this->onDuplicatesStrategy = intval($onDuplicatesStrategy);
        return $this;
    }

    public function setStatus($status)
    {
        $this->status = intval($status);
        return $this;
    }

    public function setVisibility($visibility)
    {
        $this->visibility = intval($visibility);
        return $this;
    }

    public function setTs($ts)
    {
        $this->ts = new \DateTime($ts);
        return $this;
    }
}
