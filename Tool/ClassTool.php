<?php

namespace SymfonyArt\UploadHandlerBundle\Tool;

class ClassTool
{
    /**
     * @param string $propertyName
     * @param object|string|null $object
     * @return null|string
     */
    public static function getGetter($propertyName, $object = null)
    {
        $methodName = 'get' . ucfirst($propertyName);

        if (!$object) {
            return $methodName;
        }

        if (method_exists($object, $methodName)) {
            return $methodName;
        }

        $methodName = 'is' . ucfirst($propertyName);
        if (method_exists($object, $methodName)) {
            return $methodName;
        }

        return null;
    }

    /**
     * @param string $propertyName
     * @param object|string|null $object
     * @return null|string
     */
    public static function getSetter($propertyName, $object = null)
    {
        $methodName = 'set' . ucfirst($propertyName);

        if (!$object) {
            return $methodName;
        }

        if (method_exists($object, $methodName)) {
            return $methodName;
        }

        return null;
    }
}