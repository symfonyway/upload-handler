<?php

namespace SymfonyArt\UploadHandlerBundle\Model;

abstract class BaseUploadableProperty
{
    /** @var object */
    protected $object;

    /** @var string */
    protected $propertyName;

    /**
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param object $object
     * @return $this
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * @return string
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * @param string $propertyName
     * @return $this
     */
    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;

        return $this;
    }
}