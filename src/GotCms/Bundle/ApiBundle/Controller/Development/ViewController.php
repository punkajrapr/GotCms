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

use GotCms\Core\Entity\View as ViewEntity;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * View Controller
 *
 * @category   GotCms\Bundle
 * @package    ApiBundle
 * @subpackage Controller\Development
 */
class ViewController extends BaseTemplateController
{
    /**
     * List all views
     *
     * @return array
     */
    public function getViewsAction()
    {
        return $this->getAll();
    }

    /**
     * Get view
     *
     * @param ViewEntity $view View Entity
     *
     * @ParamConverter("view", class="GotCmsCore:View")
     *
     * @return array
     */
    public function getViewAction($view)
    {
        return $this->get($view);
    }

    /**
     * Delete view
     *
     * @param ViewEntity $view View Entity
     *
     * @ParamConverter("view", class="GotCmsCore:View")
     *
     * @return array
     */
    public function deleteViewAction($view)
    {
        return $this->delete($view);
    }

    /**
     * Create view
     *
     * @param Request $request Http request object
     *
     * @return array
     */
    public function postViewAction(Request $request)
    {
        return $this->create($request->request);
    }

    /**
     * Update view
     *
     * @param Request    $request Http request object
     * @param ViewEntity $view    View Entity
     *
     * @ParamConverter("view", class="GotCmsCore:View")
     *
     * @return array
     */
    public function putViewAction(Request $request, $view)
    {
        return $this->update($view, $request->request);
    }

    /**
     * Get repository
     *
     * @return ViewRepository
     */
    protected function getRepository()
    {
        return $this->repos()->getViewRepository();
    }

    /**
     * Get Entity
     *
     * @return ViewEntity
     */
    protected function getEntity()
    {
        return new ViewEntity();
    }
}
