<?php

namespace Kebza\SequenceBundle\DependencyInjection;

use Kebza\SequenceBundle\Sequence\Replacer\ReplacerInterface;
use Kebza\SequenceBundle\Sequence\Sequence;
use Kebza\SequenceBundle\Sequence\SequenceManager;
use Kebza\SequenceBundle\Sequence\SequenceRegistry;
use Kebza\SequenceBundle\Sequence\Storage\DoctrineStorage;
use Kebza\SequenceBundle\Sequence\Storage\FileStorage;
use Kebza\SequenceBundle\Sequence\Storage\MemoryStorage;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class KebzaSequenceExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('kebza_sequence.sequences', $config['sequences']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        // Autoconfigure
        if (method_exists($container,'registerForAutoconfiguration')) {
            $container->registerForAutoconfiguration(ReplacerInterface::class)->addTag('kebza.sequence.replacer');
        }

        // Set up sequence manager storage
        $map = [
            'doctrine' => DoctrineStorage::class,
            'memory' => MemoryStorage::class,
            'file' => FileStorage::class
        ];
        $storageId = $config['storage'];
        if (array_key_exists($storageId, $map)) {
            $storageId = $map[$storageId];
        }
        $container->getDefinition(SequenceManager::class)->addArgument(new Reference($storageId));
    }

}
