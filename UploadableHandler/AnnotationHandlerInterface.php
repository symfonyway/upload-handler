<?php

namespace SymfonyArt\UploadHandlerBundle\UploadableHandler;

use SymfonyArt\UploadHandlerBundle\Model\AnnotatedProperty;

interface AnnotationHandlerInterface
{
    /**
     * @param AnnotatedProperty $annotatedProperty
     */
    public function handleCreate(AnnotatedProperty $annotatedProperty);

    /**
     * @param AnnotatedProperty $annotatedProperty
     */
    public function handleUpdate(AnnotatedProperty $annotatedProperty);

    /**
     * @param AnnotatedProperty $annotatedProperty
     */
    public function handleDelete(AnnotatedProperty $annotatedProperty);
}