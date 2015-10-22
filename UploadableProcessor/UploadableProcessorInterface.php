<?php

namespace SymfonyArt\UploadHandlerBundle\UploadableProcessor;

interface UploadableProcessorInterface
{
    /**
     * @param object $object
     */
    public function handleCreate($object);

    /**
     * @param object $object
     */
    public function handleUpdate($object);

    /**
     * @param object $object
     */
    public function handleDelete($object);
}