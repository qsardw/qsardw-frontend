<?php

namespace Qsardw\Frontend\Data;

use Qsardw\Frontend\Application;

/**
 * Description of BeanFactory
 *
 * @author Javier Caride Ulloa <javiercaride@mobail.es>
 */
class BeanFactory
{
    /**
     * Gets an empty dataset
     * @return \Qsardw\Frontend\Data\Beans\Dataset
     */
    public static function getDataset()
    {
        $dataset = new Beans\Dataset();
        
        $dataset->setStatus(0);
        $dataset->setCreatedOn(date(Application::TIMESTAMP));
        $dataset->setDistinctMolecules(0);
        $dataset->setInitialMolecules(0);
        $dataset->setIsCleaned(0);
        $dataset->setTs(date(Application::TIMESTAMP));
        
        return $dataset;
    }
}
