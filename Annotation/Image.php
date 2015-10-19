<?php

namespace SymfonyArt\UploadHandlerBundle\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 * @Attributes({
 *   @Attribute("fileProperty", type = "string"),
 *   @Attribute("filter",  type = "string"),
 * })
 */
class Image implements AnnotationInterface
{
    /**
     * @var string
     * @Required
     */
    private $fileProperty;

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
        $this->fileProperty = $values['value'];
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
    public function getFileProperty()
    {
        return $this->fileProperty;
    }
}