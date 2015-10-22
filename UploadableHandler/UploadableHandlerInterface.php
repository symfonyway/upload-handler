<?php

namespace SymfonyArt\UploadHandlerBundle\UploadableHandler;

use SymfonyArt\UploadHandlerBundle\Model\BaseUploadableProperty;

interface UploadableHandlerInterface
{
    /**
     * @param BaseUploadableProperty $uploadableProperty
     */
    public function handleCreate(BaseUploadableProperty $uploadableProperty);

    /**
     * @param BaseUploadableProperty $uploadableProperty
     */
    public function handleUpdate(BaseUploadableProperty $uploadableProperty);

    /**
     * @param BaseUploadableProperty $uploadableProperty
     */
    public function handleDelete(BaseUploadableProperty $uploadableProperty);
}