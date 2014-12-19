<?php

namespace Application\Entity;

use \RuntimeException;
use Application\Factory\ServiceLocatorFactory;

class Entity
{
    protected $entityManager;
    
    protected $propertyMapping;
    
    /**
     * Magic-Getter-Methode, um protected Felder nach außen zu öffnen.
     * Falls eine entsprechende get-Methode vorhanden ist, wird diese verwendet.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        $getter = 'get' . ucfirst($property);
        if (method_exists($this, $getter)) {
            return call_user_func(array($this, $getter));
        }
        
        return $this->$property;
    }

    /**
     * Magic-Setter-Methode, um protected Felder nach außen zu öffnen
     * Falls eine entsprechende set-Methode vorhanden ist, wird diese verwendet.
     *
     * @param string $property
     * @param mixed $value
     * @return mixed
     */
    public function __set($property, $value)
    {
        $setter = 'set' . ucfirst($property);
        if (method_exists($this, $setter)) {
            return call_user_func(array($this, $setter), $value);
        }

        $this->$property = $value;
        return $value;
    }
    
    /**
     * Is this property set or not?
     * @param string $property
     * @return boolean
     */
    public function __isset($property)
    {
        return isset($this->$property);
    }

    /**
     * Unsetting a property means: Set it to null.
     * @param string $property
     */
    public function __unset($property)
    {
        if (isset($this->$property)) {
            $this->$property = null;
        }
    }

    /**
     * @param string $name
     * @param array $arguments
     * @throws RuntimeException
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        // Betroffenes Property ermitteln: getFirstName => firstName
        $property = lcfirst(substr($name, 3));

        if (!property_exists($this, $property)) {
            throw new RuntimeException('Undefined property: ' . $name);
        }
        
        if (strpos($name, 'get') === 0) {
            return $this->$property;
        }
        
        if (strpos($name, 'set') === 0) {
            $value = array_shift($arguments);
            
            // If our property is an object but the given value is an array, we have to take further actions
            if (is_object($this->$property) && is_array($value)) {
                // If the property has a populate() method, then use it
                if (method_exists($this->$property, 'populate')) {
                    return $this->$property->populate($value);
                }
                // If the property is a Collection, populate it via its methods
                if ($this->$property instanceof \Doctrine\Common\Collections\Collection) {
                    $this->$property->clear();
                    foreach ($value as $dataset) {
                        $this->$property->add($dataset);
                    }
                    return $this->$property;
                }
                // If nothing helps, give up
                throw new RuntimeException('Object on property "'.$property.'" can\'t be filled with array');
            }
            // Default: assign the given value
            return $this->$property = $value;
        }

        throw new RuntimeException('Undefined method called: ' . $name);
    }

    /**
     * Get Doctrine Entity Manager
     * @return EntityManager
     */
    public function getEntityManager()
    {
        if (!$this->entityManager) {
            $this->entityManager = ServiceLocatorFactory::getInstance()->get('Doctrine\ORM\EntityManager');
        }
        return $this->entityManager;
    }
    
    /**
     * Return an array with "external property name" and "internal property name".
     * @return array
     * @todo Check how to return a defined order of the properties without a PHP "sort" command
     */
    public function getPropertyMapping()
    {
        if (!$this->propertyMapping) {
            $this->propertyMapping = $this->getEntityManager()
                                          ->getClassMetaData(get_called_class())
                                          ->getReflectionProperties();
            array_walk($this->propertyMapping, function (&$item, $key) { $item = $item->name; });
        }
        return $this->propertyMapping;
    }    

}
