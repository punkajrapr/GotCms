<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP version >= 5.5
 *
 * @category   GotCms\Bundle
 * @package    ApiBundle
 * @subpackage DependencyInjection
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */
namespace GotCms\Bundle\ApiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @package    ApiBundle
 * @subpackage DependencyInjection
 */
class GotCmsApiExtension extends Extension
{
    /**
     * @var array
     */
    protected $resources = array(
        'services.yml',
        'event_listener.yml'
    );

    /**
     * Loads the services based on your application configuration.
     *
     * @param array            $configs   Configurations
     * @param ContainerBuilder $container Container
     *
     * @return null
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);
        if ($config['enabled']) {
            $loader = $this->getFileLoader($container);
            foreach ($this->resources as $resource) {
                $loader->load($resource);
            }

            foreach ($config as $key => $value) {
                $container->setParameter('gotcms_api.' . $key, $value);
            }
        }
    }

    /**
     * Get File Loader
     *
     * @param ContainerBuilder $container Container
     *
     * @return null
     */
    public function getFileLoader($container)
    {
        return new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
    }
}
