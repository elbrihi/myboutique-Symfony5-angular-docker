<?php

namespace Medstor\CatalogBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


class  MedstorCatalogExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
       
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        
        $loader->load('services.xml');

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        
        $loader->load('parameters.yaml');
    }
}

?>