<?php

namespace Qsardw\Frontend\Traits;

use Qsardw\Frontend\Utils\String;

/**
 * Description of JsonUnserialize
 *
 * @author Javier Caride Ulloa <javiercaride@mobail.es>
 */
trait BeanUnserializer
{
    /**
     * Method to fill the bean properties with the values of an array
     * in which each key is the name of a database column that
     * matches a bean property
     *
     * @param array $row
     */
    public function fromRow(array $row)
    {
        foreach ($row as $column => $value) {
            $setter = $this->setterFromColumnName($column);
            if (method_exists($this, $setter)) {
                call_user_func(array($this, $setter), $value);
            }
        }
    }
    
    /**
     * Method to fill the bean properties with the values of an array
     * in which each key is the name of the a bean property
     *
     * @param type $propertiesArray
     */
    public function fromArray($values, $fillTimestamp = true)
    {
        $beanProperties = get_object_vars($this);

        foreach (array_keys($beanProperties) as $property) {
            $setter = $this->setterFromPropertyName($property);

            $value = null;
            if (array_key_exists($property, $values)) {
                $value = $values[$property];
            }

            if (($property === 'ts') && ($fillTimestamp === true)) {
                $value = date('Y-m-d H:i:s');
            }

            call_user_func(array($this, $setter), $value);
        }
    }
    
    /**
     * Returns the bean setter method for a entity property
     *
     * @param string $propertyName
     * @return string
     */
    protected function setterFromPropertyName($propertyName)
    {
        $setter = 'set' . ucfirst($propertyName);
        return $setter;
    }

    /**
     * Returns the bean setter method for a database column
     *
     * @param string $columnName
     * @return string
     */
    protected function setterFromColumnName($columnName)
    {
        $propertyName = String::underscoreCamelCaser($columnName);
        return $this->setterFromPropertyName($propertyName);
    }
}
