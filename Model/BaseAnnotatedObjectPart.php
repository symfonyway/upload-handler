<?php

namespace SymfonyArt\UploadHandlerBundle\Model;

use SymfonyArt\UploadHandlerBundle\Annotation\AnnotationInterface;

abstract class BaseAnnotatedObjectPart
{
    /** @var object */
    protected $object;

    /** @var AnnotationInterface */
    protected $annotation;

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
}