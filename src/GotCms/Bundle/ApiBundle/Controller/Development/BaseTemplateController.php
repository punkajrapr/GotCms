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

use GotCms\Core\Entity\BaseEntity;
use GotCms\Core\Mvc\Controller\BaseRestController;
use Symfony\Component\HttpFoundation\ParameterBag;

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
     * @return array
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }
    /**
     * Get view
     *
     * @param BaseEntity $entity Template model entity
     *
     * @return array
     */
    public function get($entity)
    {
        return $entity;
    }
    /**
     * Create view
     *
     * @param ParameterBag $request Post request
     *
     * @return array
     */
    public function create($request)
    {
        $entity = $this->getEntity();
        $entity->setIdentifier($request->get('identifier'));
        $entity->setDescription($request->get('description'));
        $entity->setName($request->get('name'));
        $entity->setContent($request->get('content'));

        $validator = $this->container->get('validator');
        $errors    = $validator->validate($entity);
        if (!empty(count($errors))) {
            return $this->badRequest((string) $errors);
        }

        $this->em()->persist($entity);
        $this->em()->flush();

        return $entity;
    }

    /**
     * Edit view
     *
     * @param BaseEntity   $entity  Template model entity
     * @param ParameterBag $request Post request
     *
     * @return array
     */
    public function update($entity, $request)
    {
        if (!empty($request->get('identifier'))) {
            $entity->setIdentifier($request->get('identifier'));
        }

        if (!empty($request->get('description'))) {
            $entity->setDescription($request->get('description'));
        }

        if (!empty($request->get('name'))) {
            $entity->setName($request->get('name'));
        }

        if (!empty($request->get('content'))) {
            $entity->setContent($request->get('content'));
        }

        $validator = $this->container->get('validator');
        $errors    = $validator->validate($entity);
        if (!empty(count($errors))) {
            return $this->badRequest((string) $errors);
        }

        $this->em()->persist($entity);
        $this->em()->flush();

        return $entity;
    }

    /**
     * Delete entity
     *
     * @param BaseEntity $entity Template model entity
     *
     * @return null
     */
    public function delete($entity)
    {
        $this->em()->remove($entity);
        $this->em()->flush();

        return;
    }
}
