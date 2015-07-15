<?php
/*
 * This file is part of the QSARDW Frontend project
 *
 * (c) Javier Caride Ulloa <javier.caride@qsardw.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Qsardw\Frontend\Traits;

use Qsardw\Frontend\Application;
use Qsardw\Frontend\Utils\String;

/**
 * @author Javier Caride Ulloa <javier.caride@qsardw.org>
 */
trait BeanSerializer
{
    /**
     * Returns an key-value array with the data contained in the object
     *
     * @return array
     */
    public function toArray($getNulls = true)
    {
        $objectProperties = get_object_vars($this);
        $objectArray = array();

        foreach ($objectProperties as $property => $propertyValue) {
            if ($getNulls === true) {
                $objectArray[$property] = $this->getPropertyValue($propertyValue);
            } else {
                if ($propertyValue !== null) {
                    $objectArray[$property] = $this->getPropertyValue($propertyValue);
                }
            }
        }

        ksort($objectArray);

        return $objectArray;
    }
    
    /**
     * Returns the bean data as it's needed by database to deal with database
     *
     * @return array Bean data represented as a database row
     */
    public function toRow($getNulls = true)
    {
        $row = array();

        $objectProperties = get_object_vars($this);

        foreach ($objectProperties as $property => $propertyValue) {
            $columnName = String::camelcaseUnderscorer($property);
            if ($getNulls === true) {
                $row[$columnName] = $this->getPropertyValue($propertyValue);
            } else {
                if ($propertyValue !== null) {
                    $row[$columnName] = $this->getPropertyValue($propertyValue);
                }
            }
        }
        
        ksort($row);

        return $row;
    }

    /**
     * Converts the object to JSON representation
     *
     * @return type
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
    
    /**
     * Returns the right value of a property
     *
     * @param mixed $propertyValue
     * @return mixed
     */
    protected function getPropertyValue($propertyValue)
    {
        if ($propertyValue instanceof \DateTime) {
            return $propertyValue->format(Application::TIMESTAMP);
        } else {
            return $propertyValue;
        }
    }
}
