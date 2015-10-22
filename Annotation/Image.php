<?php

namespace SymfonyArt\UploadHandlerBundle\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 * @Attributes({
 *   @Attribute("pathProperty", type = "string"),
 *   @Attribute("filter",  type = "string"),
 * })
 */
class Image implements AnnotationInterface
{
    /**
     * @var string
     * @Required
     */
    private $pathProperty;

    /**
     * @var string
     * @Required
     */
    private $filter;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->pathProperty = $values['value'];
        $this->filter = $values['filter'];
    }

    /**
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @return string
     */
    public function getPathProperty()
    {
        return $this->pathProperty;
    }

    /**
     * @return string
     */
    public function getHandlerName()
    {
        return 'symfonyart_upload_handler.uploadable_handler.image_handler';
    }
}