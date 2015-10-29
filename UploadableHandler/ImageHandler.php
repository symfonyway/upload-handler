<?php

namespace SymfonyArt\UploadHandlerBundle\UploadableHandler;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use SymfonyArt\UploadHandlerBundle\Annotation\Image;
use SymfonyArt\UploadHandlerBundle\Exception\ConfigurationException;
use SymfonyArt\UploadHandlerBundle\Exception\RuntimeException;
use SymfonyArt\UploadHandlerBundle\Exception\UploadHandleException;
use SymfonyArt\UploadHandlerBundle\Model\AnnotatedProperty;
use SymfonyArt\UploadHandlerBundle\Tool\ClassTool;

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
        $this->handle($annotatedProperty);
    }

    /**
     * @param AnnotatedProperty $annotatedProperty
     */
    public function handleUpdate(AnnotatedProperty $annotatedProperty)
    {
        $this->handle($annotatedProperty);
    }

    /**
     * @param AnnotatedProperty $annotatedProperty
     */
    public function handleDelete(AnnotatedProperty $annotatedProperty)
    {
        // TODO: Implement handleDelete() method.
    }

    private function handle(AnnotatedProperty $annotatedProperty)
    {
        $propertyReflection = $annotatedProperty->getPropertyReflection();
        /** @var Image $annotation */
        $annotation = $annotatedProperty->getAnnotation();
        $object = $annotatedProperty->getObject();

        $propertyReflection->setAccessible(true);

        if (!$file = $propertyReflection->getValue($object)) {
            return;
        }

        $pathProperty = $annotation->getPathProperty();
        $pathGetter = ClassTool::getGetter($pathProperty, $object);
        $pathSetter = ClassTool::getSetter($pathProperty, $object);

        $filter = $annotation->getFilter();
        $content = $this->getFileContent($file);
        if (!$path = $this->imageHandler->handle($content, $filter)) {
            throw new UploadHandleException(sprintf('Image handler error: %s.', $this->imageHandler->getError()));
        }

        $object->{$pathSetter}($path);
        $propertyReflection->setValue($object, null);
    }

    /**
     * @param UploadedFile $file
     * @return string
     * @throws RuntimeException
     */
    private function getFileContent(UploadedFile $file)
    {
        $fileRealPath = $file->getRealPath();
        if (!$content = file_get_contents($fileRealPath)) {
            throw new RuntimeException(sprintf('Can\'t get content of \'%s\'.', $fileRealPath));
        }

        return $content;
    }
}