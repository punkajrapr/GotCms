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

/**
 * View Controller
 *
 * @category   GotCms\Bundle
 * @package    ApiBundle
 * @subpackage Controller\Development
 */
class ViewController extends BaseTemplateController
{
    public function getViewsAction()
    {
        $this->getAll();
    }

    public function getViewAction($id)
    {
        $this->get($id);
    }

    public function deleteViewAction()
    {
        $this->delete();
    }

    public function postViewAction()
    {
        $this->create();
    }

    public function putViewAction()
    {
        $this->update();
    }

    protected function getCollection()
    {
        return new View\Collection();
    }

    protected function getModel()
    {
        return new View\Model();
    }

    protected function loadModel($id)
    {
        return View\Model::fromId((int) $id);
    }
}
