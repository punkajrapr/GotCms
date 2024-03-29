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

use GotCms\Core\Entity\Script as ScriptEntity;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Script Controller
 *
 * @category   GotCms\Bundle
 * @package    ApiBundle
 * @subpackage Controller\Development
 */
class ScriptController extends BaseTemplateController
{
    /**
     * List all scripts
     *
     * @return array
     */
    public function getScriptsAction()
    {
        return $this->getAll();
    }

    /**
     * Get script
     *
     * @param ScriptEntity $script Script Entity
     *
     * @ParamConverter("script", class="GotCmsCore:Script")
     *
     * @return array
     */
    public function getScriptAction($script)
    {
        return $this->get($script);
    }

    /**
     * Delete script
     *
     * @param ScriptEntity $script Script Entity
     *
     * @ParamConverter("script", class="GotCmsCore:Script")
     *
     * @return array
     */
    public function deleteScriptAction($script)
    {
        return $this->delete($script);
    }

    /**
     * Create script
     *
     * @param Request $request Http request object
     *
     * @return array
     */
    public function postScriptAction(Request $request)
    {
        return $this->create($request->request);
    }

    /**
     * Update script
     *
     * @param Request      $request Http request object
     * @param ScriptEntity $script  Script Entity
     *
     * @ParamConverter("script", class="GotCmsCore:Script")
     *
     * @return array
     */
    public function putScriptAction(Request $request, $script)
    {
        return $this->update($script, $request->request);
    }

    /**
     * Get repository
     *
     * @return ScriptRepository
     */
    protected function getRepository()
    {
        return $this->repos()->getScriptRepository();
    }

    /**
     * Get Entity
     *
     * @return ScriptEntity
     */
    protected function getEntity()
    {
        return new ScriptEntity();
    }
}
