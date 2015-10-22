<?php

namespace SymfonyArt\UploadHandlerBundle\UploadableProcessor;

use SymfonyArt\UploadHandlerBundle\AnnotationHandlerCollector\AnnotationHandlerCollector;
use SymfonyArt\UploadHandlerBundle\Model\AnnotatedProperty;
use SymfonyArt\UploadHandlerBundle\Tool\AnnotationReader;
use SymfonyArt\UploadHandlerBundle\UploadableHandler\AnnotationHandlerInterface;

class AnnotationProcessor implements UploadableProcessorInterface
{
    /** @var AnnotationReader */
    private $annotationReader;

    /** @var AnnotationHandlerCollector */
    private $annotationHandlerCollector;

    /**
     * @param AnnotationReader $annotationReader
     */
    public function __construct(AnnotationReader $annotationReader, AnnotationHandlerCollector $annotationHandlerCollector)
    {
        $this->annotationReader = $annotationReader;
        $this->annotationHandlerCollector = $annotationHandlerCollector;
    }

    /**
     * @param object $object
     */
    public function handleCreate($object)
    {
        $this->forAllAnnotatedProperties(
            $object,
            function(AnnotationHandlerInterface $annotationHandler, AnnotatedProperty $annotatedProperty) {
                $annotationHandler->handleCreate($annotatedProperty);
            }
        );
    }

    /**
     * @param object $object
     */
    public function handleUpdate($object)
    {
        $this->forAllAnnotatedProperties(
            $object,
            function(AnnotationHandlerInterface $annotationHandler, AnnotatedProperty $annotatedProperty) {
                $annotationHandler->handleUpdate($annotatedProperty);
            }
        );
    }

    /**
     * @param object $object
     */
    public function handleDelete($object)
    {
        $this->forAllAnnotatedProperties(
            $object,
            function(AnnotationHandlerInterface $annotationHandler, AnnotatedProperty $annotatedProperty) {
                $annotationHandler->handleDelete($annotatedProperty);
            }
        );
    }

    /**
     * @param object $object
     * @param callable $callback
     */
    private function forAllAnnotatedProperties($object, \Closure $callback)
    {
        $annotatedProperties = $this->annotationReader->findAnnotatedProperties($object);

        foreach ($annotatedProperties as $annotatedProperty) {
            $annotationHandler = $this->getAnnotationHandler($annotatedProperty);

            $callback($annotationHandler, $annotatedProperty);
        }
    }

    /**
     * @param AnnotatedProperty $annotatedProperty
     * @return \SymfonyArt\UploadHandlerBundle\UploadableHandler\AnnotationHandlerInterface
     * @throws \SymfonyArt\UploadHandlerBundle\Exception\AnnotationException
     * @throws \SymfonyArt\UploadHandlerBundle\Exception\ConfigurationException
     */
    private function getAnnotationHandler(AnnotatedProperty $annotatedProperty)
    {
        $annotation = $annotatedProperty->getAnnotation();
        $annotationHandler = $this->annotationHandlerCollector->findHandlerByAnnotation($annotation);

        return $annotationHandler;
    }
}
