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

use GotCms\Core\Mvc\Controller\BaseRestController;

/**
 * BaseTemplate Controller
 *
 * @category   GotCms\Bundle
 * @package    ApiBundle
 * @subpackage Controller\Development
 */
class BaseTemplateController extends BaseRestController
{
    /**
     * List all views
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function getAll()
    {
        $collection = $this->getCollection();
        $return         = array();
        foreach ($collection->getAll() as $view) {
            $return[] = $view->toArray();
        }

        return array('templates' => $return);
    }
    /**
     * Get view
     *
     * @param integer $id Id of the view model
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function get($id)
    {
        $model = $this->loadModel($id);
        if (empty($model)) {
            return $this->notFoundAction();
        }
        return array('template' => $model->toArray());
    }
    /**
     * Create view
     *
     * @param array $data Data returns
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function create($data)
    {
        $filter = new ViewFilter($this->getServiceLocator()->get('DbAdapter'));
        $filter->setData($data);
        if (!$filter->isValid()) {
            return $this->badRequest($filter->getMessages());
        }

        $model = $this->getModel();
        $model->setName($filter->getValue('name'));
        $model->setIdentifier($filter->getValue('identifier'));
        $model->setDescription($filter->getValue('description'));
        $model->setContent($filter->getValue('content'));
        $model->save();
        return $model->toArray();
    }

    /**
     * Edit view
     *
     * @param integer $id   Id of the view
     * @param array   $data Data returns
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function update($id, $data)
    {
        $model = $this->loadModel($id);
        if (empty($model)) {
            return $this->notFoundAction();
        }

        $filter = new ViewFilter($this->getServiceLocator()->get('DbAdapter'));
        $filter->setData($data);
        if (! $filter->isValid()) {
            return $this->badRequest($filter->getMessages());
        }

        $model->setName($filter->getValue('name'));
        $model->setIdentifier($filter->getValue('identifier'));
        $model->setDescription($filter->getValue('description'));
        $model->setContent($filter->getValue('content'));
        $model->save();
        return $model->toArray();
    }
    /**
     * Delete View
     *
     * @param integer $id Id of the view
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function delete($id)
    {
        $view = $this->loadModel($id);
        if (!empty($view) and $view->delete()) {
            return array('message' => 'This view has been deleted.');
        }

        return $this->notFoundAction();
    }
}
