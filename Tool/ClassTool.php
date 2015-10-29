<?php

namespace SymfonyArt\UploadHandlerBundle\Tool;

use SymfonyArt\UploadHandlerBundle\Exception\ClassToolException;

class ClassTool
{
    /**
     * @param $propertyName
     * @param object $object
     * @throws ClassToolException
     */
    public static function getGetter($propertyName, $object = null)
    {
        $methodName = 'get' . ucfirst($propertyName);

        if (!$object) {
            return $methodName;
        }

        if (!is_object($object)) {
            throw new ClassToolException(sprintf('Variable must be an object, %s given.', gettype($object)));
        }

        if (method_exists($object, $methodName)) {
            return $methodName;
        }

        $methodName = 'is' . ucfirst($propertyName);
        if (method_exists($object, $methodName)) {
            return $methodName;
        }

        throw new ClassToolException(sprintf('Can\'t find getter for %s::$%s.', get_class($object), $propertyName));
    }

    /**
     * @param $propertyName
     * @param object $object
     * @throws ClassToolException
     */
    public static function getSetter($propertyName, $object = null)
    {
        $methodName = 'set' . ucfirst($propertyName);

        if (!$object) {
            return $methodName;
        }

        if (!is_object($object)) {
            throw new ClassToolException(sprintf('Variable must be an object, %s given.', gettype($object)));
        }

        if (method_exists($object, $methodName)) {
            return $methodName;
        }

        throw new ClassToolException(sprintf('Can\'t find getter for %s::$%s.', get_class($object), $propertyName));
    }
}