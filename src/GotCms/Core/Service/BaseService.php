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
 * @category   GotCms\Core
 * @package    GotCms\Core
 * @subpackage Service
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */
namespace GotCms\Core\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Base Entity
 *
 * @package    GotCms\Core
 * @subpackage Service
 */
abstract class BaseService
{
    use ContainerAwareTrait;

    /**
     * Get logger
     *
     * @return Logger
     */
    public function getLogger()
    {
        return $this->container->get('logger');
    }

    /**
     * Get Task logger
     *
     * @return Logger
     */
    public function getTaskLogger()
    {
        return $this->container->get('monolog.logger.tasks');
    }

    /**
     * Get services
     *
     * @return ServicesService
     */
    public function services()
    {
        return $this->container->get('gotcms.services');
    }

    /**
     * Get entity manager
     *
     * @return EntityManager
     */
    public function em()
    {
        return $this->container->get('doctrine')->getManager();
    }

    /**
     * Get repositories
     *
     * @return RepositoryService
     */
    public function repos()
    {
        return $this->container->get('gotcms.repos');
    }
}
