<?php

namespace SymfonyArt\UploadHandlerBundle\Tool;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Collections\ArrayCollection;
use SymfonyArt\UploadHandlerBundle\Model\AnnotatedProperty;

class AnnotationReader
{
    /** @var Reader */
    private $reader;

    /**
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @param object $object
     * @return AnnotatedProperty[]|ArrayCollection
     */
    public function findAnnotatedProperties($object)
    {
        $annotatedProperties = new ArrayCollection();

        $objectReflection = new \ReflectionObject($object);
        $propertyReflections = $objectReflection->getProperties();

        foreach ($propertyReflections as $propertyReflection) {
            $annotations = $this->reader->getPropertyAnnotations($propertyReflection);

            foreach ($annotations as $annotation) {
                if (!($annotation instanceof AnnotationInterface)) {
                    continue;
                }

                $annotatedProperty = new AnnotatedProperty();
                $annotatedProperty->setObject($object);
                $annotatedProperty->setPropertyName($propertyReflection->getName());
                $annotatedProperty->setPropertyReflection($propertyReflection);
                $annotatedProperty->setAnnotation($annotation);

                $annotatedProperties->add($object);
            }
        }

        return $annotatedProperties;
    }
}