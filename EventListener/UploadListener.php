<?php

namespace SymfonyArt\UploadHandlerBundle\EventListener;

use SymfonyArt\UploadHandlerBundle\Annotation\AnnotationInterface;
use SymfonyArt\UploadHandlerBundle\Annotation\Image;
use SymfonyArt\UploadHandlerBundle\Entity\ImageUploadableInterface;
use SymfonyArt\UploadHandlerBundle\Exception\ConfigurationException;
use SymfonyArt\UploadHandlerBundle\Exception\UploadHandleException;
use SymfonyArt\UploadHandlerBundle\Service\ImageHandler;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Annotations\Reader;
use SymfonyArt\UploadHandlerBundle\Tool\ClassTool;
use SymfonyArt\UploadHandlerBundle\UploadableProcessor\UploadableProcessorInterface;

/**
 * Class UploadListener
 * @package AppBundle\EventListener
 *
 * Extend your entity with ImageUploadableInterface and add EntityListener annotation with that class as a value
 */
class UploadListener
{
    /** @var UploadableProcessorInterface */
    private $uploadableProcessor;

    /** @var Reader */
    private $reader;

    /** @var ImageHandler */
    private $imageHandler;

    /**
     * @param \SymfonyArt\UploadHandlerBundle\Service\ImageHandler $imageHandler
     */
    public function __construct(UploadableProcessorInterface $uploadableProcessor, Reader $reader, ImageHandler $imageHandler)
    {
        $this->uploadableProcessor = $uploadableProcessor;
        $this->reader = $reader;
        $this->imageHandler = $imageHandler;
    }

    /**
     * @param object $entity
     */
    public function preUpdate($entity)
    {
        $this->uploadableProcessor->handleUpdate($entity);
//        $this->handleUpload($entity);
    }

    /**
     * @param object $entity
     */
    public function prePersist($entity)
    {
        $this->uploadableProcessor->handleCreate($entity);
//        $this->handleUpload($entity);
    }

    /**
     * @param \SymfonyArt\UploadHandlerBundle\Entity\ImageUploadableInterface $entity
     */
    public function preRemove(ImageUploadableInterface $entity)
    {
        $this->uploadableProcessor->handleDelete($entity);
//        foreach ($entity->getImageProperties() as $property => $filter) {
//            $filepath = $entity->{'get'.ucfirst($property)}();
//
//            if (file_exists($filepath)) {
//                unlink($filepath);
//            }
//        }
    }

    /**
     * @param object $entity
     * @throws ConfigurationException
     * @throws UploadHandleException
     */
    private function handleUpload($entity)
    {
        $entityReflection = new \ReflectionObject($entity);
        $propertyReflections = $entityReflection->getProperties();

        foreach ($propertyReflections as $propertyReflection) {
            /** @var \ReflectionProperty $propertyReflection */
            $propertyReflection = $propertyReflection;
            $annotations = $this->reader->getPropertyAnnotations($propertyReflection);

            foreach ($annotations as $annotation) {
                if (!($annotation instanceof AnnotationInterface)) {
                    continue;
                }

                //TODO: support all AnnotationInterface annotations
                if (!is_a($annotation, 'SymfonyArt\UploadHandlerBundle\Annotation\Image')) {
                    throw new ConfigurationException('Only Image annotation supports now.');
                }

                $this->uploadImage($entity, $entityReflection, $propertyReflection, $annotation);
            }
        }


//        foreach ($entity->getImageProperties() as $property => $filter) {
//            if (null === $entity->{'get'.ucfirst($property).'File'}()) {
//                continue;
//            }
//
//            /** @var UploadedFile $file */
//            $file = $entity->{'get'.ucfirst($property).'File'}();
//            $path = $this->imageHandler->handle(file_get_contents($file->getRealPath()), $filter);
//
//            if (!$path) {
//                throw new UploadHandleException($this->imageHandler->getError());
//            }
//
//            $entity->{'set'.ucfirst($property)}($path);
//            $entity->{'set'.ucfirst($property).'File'}(null);
//        }
    }

    /**
     * @param $entity
     * @param \ReflectionObject $reflectionObject
     * @param \ReflectionProperty $propertyReflection
     * @param Image $annotation
     * @throws UploadHandleException
     * @throws \UploadHandleException
     */
    private function uploadImage($entity, \ReflectionObject $reflectionObject, \ReflectionProperty $propertyReflection, Image $annotation)
    {
        $filePropertyName = $annotation->getFileProperty();
        $fileProperty = $reflectionObject->getProperty($filePropertyName);

        /** @var UploadedFile $file */
        if (!$file = $fileProperty->getValue()) {
            return;
        }
        if (!is_a($file, 'Symfony\Component\HttpFoundation\File\UploadedFile')) {
            throw new \UploadHandleException(sprintf('Property %s contains %s, instance of Symfony\Component\HttpFoundation\File\UploadedFile expected.', $filePropertyName, get_class($file)));
        }

        $filter = $annotation->getFilter();
        $path = $this->imageHandler->handle(file_get_contents($file->getRealPath()), $filter);

        if (!$path) {
            throw new UploadHandleException($this->imageHandler->getError());
        }

        $pathPropertyName = $propertyReflection->getName();
        if ($pathPropertySetter = ClassTool::getSetter($pathPropertyName, $entity)) {
            $entity->{$pathPropertySetter}($path);
        } else {
            $propertyReflection->setValue($entity, $path);
        }

        if ($filePropertySetter = ClassTool::getSetter($filePropertyName, $entity)) {
            $entity->{$filePropertySetter}(null);
        } else {
            $fileProperty->setValue($entity, $path);
        }
    }
}