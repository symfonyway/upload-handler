<?php

namespace SymfonyArt\UploadHandlerBundle\AnnotationHandlerCollector;

use Doctrine\Common\Collections\ArrayCollection;
use SymfonyArt\UploadHandlerBundle\Annotation\AnnotationInterface;
use SymfonyArt\UploadHandlerBundle\Exception\AnnotationException;
use SymfonyArt\UploadHandlerBundle\Exception\ConfigurationException;
use SymfonyArt\UploadHandlerBundle\UploadableHandler\AnnotationHandlerInterface;

class AnnotationHandlerCollector
{
    const TAG_ANNOTATION_HANDLER = 'symfonyart_upload_handler.annotation_handler';

    /** @var AnnotationHandlerInterface[]|ArrayCollection */
    private $annotationHandlers;

    public function __construct()
    {
        $this->annotationHandlers = new ArrayCollection();
    }

    /**
     * @param string $handlerName
     * @param AnnotationHandlerInterface $annotationHandler
     * @throws ConfigurationException
     */
    public function registerAnnotationHandler($handlerName, AnnotationHandlerInterface $annotationHandler)
    {
        if (!strlen($handlerName)) {
            throw new ConfigurationException('Trying to register AnnotationHandler without a name.');
        }

        if ($this->annotationHandlers->containsKey($handlerName)) {
            throw new ConfigurationException(sprintf('AnnotationHandler with a name %s already registered.', $handlerName));
        }

        $this->annotationHandlers->set($handlerName, $annotationHandler);
    }

    /**
     * @param AnnotationInterface $annotation
     * @return AnnotationHandlerInterface
     * @throws AnnotationException
     * @throws ConfigurationException
     */
    public function findHandlerByAnnotation(AnnotationInterface $annotation)
    {
        if (!$handlerName = (string)$annotation->getHandlerName()) {
            throw new AnnotationException(sprintf('Annotation %s doesn\'t contain AnnotationHandler name in method \'getHandlerName()\'.', get_class($annotation)));
        }

        if (!$annotationHandler = $this->annotationHandlers->get($handlerName)) {
            throw new ConfigurationException(sprintf('Can\'t find AnnotationHandler with name %s. Maybe you forget to register it as a service with a tag \'%s\',', $handlerName, self::TAG_ANNOTATION_HANDLER));
        }

        return $annotationHandler;
    }
}