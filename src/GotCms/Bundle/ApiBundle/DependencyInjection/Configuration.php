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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * @category   GotCms\Bundle
 * @package    ApiBundle
 * @subpackage DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Config tree builder
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('got_cms_api');

        $rootNode
            ->children()
            ->booleanNode('enabled')->defaultTrue()->end()
            ->scalarNode('templates_path')->defaultValue('%kernel.root_dir%/../var/templates')->end()
            // ->scalarNode('cache_is_active')->defaultFalse()->end()
            // ->scalarNode('cache_handler')->defaultValue('filesystem')->end()
            // ->scalarNode('cache_lifetime')->defaultValue(600)->end()
            // ->scalarNode('session_path')->end()
            // ->scalarNode('session_handler')->defaltValue(0)->end()
            // ->scalarNode('site_offline_document')->end()
            // ->scalarNode('site_404_layout')->end()
            // ->scalarNode('site_exception_layout')->end()
            // ->scalarNode('cookie_path')->defaltValue('/')->end()
            // ->scalarNode('unsecure_frontend_base_path')->end()
            // ->scalarNode('secure_frontend_base_path')->end()
            // ->scalarNode('unsecure_backend_base_path')->end()
            // ->scalarNode('secure_backend_base_path')->end()
            // ->scalarNode('unsecure_cdn_base_path')->end()
            // ->scalarNode('secure_cdn_base_path')->end()
            // ->booleanNode('force_backend_ssl')->defaultFalse()->end()
            // ->booleanNode('force_frontend_ssl')->defaultFalse()->end()
            ->end();

        return $treeBuilder;
    }
}
