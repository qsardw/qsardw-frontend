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

use Qsardw\Frontend\Application;

/**
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
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
