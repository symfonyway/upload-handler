<?php

namespace SymfonyArt\UploadHandlerBundle\Model;

class AnnotatedProperty extends BaseAnnotatedObjectPart
{
    /** @var \ReflectionProperty */
    private $propertyReflection;

    /**
     * @return \ReflectionProperty
     */
    public function getPropertyReflection()
    {
        return $this->propertyReflection;
    }

    /**
     * @param \ReflectionProperty $propertyReflection
     * @return $this
     */
    public function setPropertyReflection($propertyReflection)
    {
        $this->propertyReflection = $propertyReflection;

        return $this;
    }
}