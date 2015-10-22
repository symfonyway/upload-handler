<?php

namespace SymfonyArt\UploadHandlerBundle\UploadableHandler;

use SymfonyArt\UploadHandlerBundle\Model\AnnotatedProperty;

class ImageHandler implements AnnotationHandlerInterface
{
    /** @var \SymfonyArt\UploadHandlerBundle\Service\ImageHandler */
    private $imageHandler;

    public function __construct(\SymfonyArt\UploadHandlerBundle\Service\ImageHandler $imageHandler)
    {
        $this->imageHandler = $imageHandler;
    }

    /**
     * @param AnnotatedProperty $annotatedProperty
     */
    public function handleCreate(AnnotatedProperty $annotatedProperty)
    {
        // TODO: Implement handleCreate() method.
    }

    /**
     * @param AnnotatedProperty $annotatedProperty
     */
    public function handleUpdate(AnnotatedProperty $annotatedProperty)
    {
        // TODO: Implement handleUpdate() method.
    }

    /**
     * @param AnnotatedProperty $annotatedProperty
     */
    public function handleDelete(AnnotatedProperty $annotatedProperty)
    {
        // TODO: Implement handleDelete() method.
    }
}