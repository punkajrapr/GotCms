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
 * @category   GotCms\Bundle\ApiBundle
 * @package    GotCms\Bundle\ApiBundle
 * @subpackage Service
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */
namespace GotCms\Bundle\ApiBundle\Service;

use GotCms\Bundle\ApiBundle\Repository\ViewRepository;
use GotCms\Bundle\ApiBundle\Repository\LayoutRepository;
use GotCms\Bundle\ApiBundle\Repository\ScriptRepository;

/**
 * Base Entity
 *
 * @package    GotCms\Bundle\ApiBundle
 * @subpackage Service
 */
class RepositoryService extends BaseService
{
    /**
     * Get view repository
     *
     * @return ViewRepository
     */
    public function getViewRepository()
    {
        return $this->em()->getRepository('GotCmsApiBundle:View');
    }

    /**
     * Get layout repository
     *
     * @return LayoutRepository
     */
    public function getLayoutRepository()
    {
        return $this->em()->getRepository('GotCmsApiBundle:Layout');
    }

    /**
     * Get script repository
     *
     * @return ScriptRepository
     */
    public function getScriptRepository()
    {
        return $this->em()->getRepository('GotCmsApiBundle:Script');
    }
}
