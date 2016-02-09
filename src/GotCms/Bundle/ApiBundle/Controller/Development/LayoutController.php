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
 * @subpackage Controller\Development
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */
namespace GotCms\Bundle\ApiBundle\Controller\Development;

use GotCms\Core\Entity\Layout as LayoutEntity;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Layout Controller
 *
 * @category   GotCms\Bundle
 * @package    ApiBundle
 * @subpackage Controller\Development
 */
class LayoutController extends BaseTemplateController
{
    /**
     * List all layouts
     *
     * @return array
     */
    public function getLayoutsAction()
    {
        return $this->getAll();
    }

    /**
     * Get layout
     *
     * @param LayoutEntity $layout Layout Entity
     *
     * @ParamConverter("layout", class="GotCmsCore:Layout")
     *
     * @return array
     */
    public function getLayoutAction($layout)
    {
        return $this->get($layout);
    }

    /**
     * Delete layout
     *
     * @param LayoutEntity $layout Layout Entity
     *
     * @ParamConverter("layout", class="GotCmsCore:Layout")
     *
     * @return array
     */
    public function deleteLayoutAction($layout)
    {
        return $this->delete($layout);
    }

    /**
     * Create layout
     *
     * @param Request $request Http request object
     *
     * @return array
     */
    public function postLayoutAction(Request $request)
    {
        return $this->create($request->request);
    }

    /**
     * Update layout
     *
     * @param Request      $request Http request object
     * @param LayoutEntity $layout  Layout Entity
     *
     * @ParamConverter("layout", class="GotCmsCore:Layout")
     *
     * @return array
     */
    public function putLayoutAction(Request $request, $layout)
    {
        return $this->update($layout, $request->request);
    }

    /**
     * Get repository
     *
     * @return LayoutRepository
     */
    protected function getRepository()
    {
        return $this->repos()->getLayoutRepository();
    }

    /**
     * Get Entity
     *
     * @return LayoutEntity
     */
    protected function getEntity()
    {
        return new LayoutEntity();
    }
}
