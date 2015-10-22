<?php

namespace SymfonyArt\UploadHandlerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class HandlerRegistrationCompilerPass implements CompilerPassInterface
{
    const SERVICE_HANDLER_STORAGE = 'symfonyart_upload_handler.uploadable_handler_storage.annotation_handler_storage';
    const TAG_ANNOTATION_HANDLER = 'symfonyart_upload_handler.annotation_handler';
    const METHOD_REGISTER_HANDLER = 'registerUploadableHandler';

    /**
     * @param ContainerBuilder $container
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $handlerStorageDefinition = $container->findDefinition(self::SERVICE_HANDLER_STORAGE);
        $annotationHandlers = $container->findTaggedServiceIds(self::TAG_ANNOTATION_HANDLER);

        foreach ($annotationHandlers as $annotationHandlerName => $tags) {
            $handlerStorageDefinition->addMethodCall(
                self::METHOD_REGISTER_HANDLER,
                array($annotationHandlerName, new Reference($annotationHandlerName))
            );
        }
    }
}