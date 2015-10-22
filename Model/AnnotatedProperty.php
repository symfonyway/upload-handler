<?php

namespace SymfonyArt\UploadHandlerBundle\Model;

use SymfonyArt\UploadHandlerBundle\Annotation\AnnotationInterface;

class AnnotatedProperty extends BaseUploadableProperty
{
    /** @var \ReflectionProperty */
    private $propertyReflection;

    /** @var AnnotationInterface */
    private $annotation;

    /**
     * @return AnnotationInterface
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * @param AnnotationInterface $annotation
     * @return $this
     */
    public function setAnnotation($annotation)
    {
        $this->annotation = $annotation;

        return $this;
    }

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