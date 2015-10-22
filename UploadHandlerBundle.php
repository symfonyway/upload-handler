<?php

namespace SymfonyArt\UploadHandlerBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymfonyArt\UploadHandlerBundle\DependencyInjection\Compiler\HandlerRegistrationCompilerPass;

class UploadHandlerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new HandlerRegistrationCompilerPass());
    }
}
