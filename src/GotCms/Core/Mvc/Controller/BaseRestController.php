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
 * PHP Version >=5.3
 *
 * @category   GotCms
 * @package    Core
 * @subpackage Mvc\Controller
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */

namespace GotCms\Core\Mvc\Controller;

use GotCms\Core\Event\StaticEventManager;
use GotCms\Core\Module\Model as ModuleModel;
use GotCms\Core\User\Model as UserModel;
use GotCms\Core\User\Role\Model as RoleModel;
use Monolog\Logger;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Extension of AbstractActionController
 *
 * @category   GotCms
 * @package    Core
 * @subpackage Mvc\Controller
 */
class BaseRestController extends FOSRestController
{
    /**
     * Route available for installer
     *
     * @var array
     */
    protected $installerRoutes = [
        'install',
        'install/check-config',
        'install/license',
        'install/database',
        'install/configuration',
        'install/complete'
    ];

    /**
     * Abstract acl
     *
     * @var array
     */
    protected $aclPage;

    /**
     * Execute the request
     *
     * @param MvcEvent $e Mvc Event
     *
     * @return mixed
     */
    public function onDispatch(MvcEvent $e)
    {
        $resultResponse = $this->construct();
        if (!empty($resultResponse)) {
            return $resultResponse;
        }

        $resultResponse = $this->init();
        if (!empty($resultResponse)) {
            return $resultResponse;
        }

        return parent::onDispatch($e);
    }

    /**
     * Initiliaze
     *
     * @return mixed
     */
    public function init()
    {

    }

    /**
     * Get repositories
     *
     * @return \GotCms\Bundle\ApiBundle\Services\RepositoryService
     */
    public function repos()
    {
        return $this->container->get('gotcms.repos');
    }

    /**
     * Get doctrine entity manager
     *
     * @return EntityManager
     */
    public function em()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * Constructor
     *
     * @return JsonResponse|null
     */
    protected function construct()
    {
        $routeName = $this->getEvent()->getRouteMatch()->getMatchedRouteName();

        /**
         * Installation check, and check on removal of the install directory.
         */
        $config = $this->getServiceLocator()->container->get('Config');
        if (!isset($config['db'])
            and !in_array($routeName, $this->installerRoutes)
        ) {
            return $this->redirect()->toRoute('install');
        } elseif (!in_array($routeName, $this->installerRoutes)) {
            $auth = $this->getServiceLocator()->container->get('Auth');
            if (!$auth->hasIdentity()) {
                if (!in_array(
                    $routeName,
                    [
                        'config/user/login',
                        'config/user/forgot-password',
                        'config/user/forgot-password-key',
                        'cms'
                    ]
                )
                ) {
                    return $this->redirect()->toRoute(
                        'config/user/login',
                        ['redirect' => base64_encode($this->getRequest()->getRequestUri())]
                    );
                }
            } else {
                if (!in_array($routeName, ['config/user/forbidden', 'config/user/logout'])) {
                    $resultResponse = $this->checkAcl($auth->getIdentity());
                    if (!empty($resultResponse)) {
                        return $resultResponse;
                    }
                }
            }
        }

        $this->layout()->setVariable('routeParams', $this->getEvent()->getRouteMatch()->getParams());
        $this->layout()->setVariable('version', \GotCms\Core\Version::VERSION);
    }

    /**
     * Retrieve event manager
     *
     * @return \GotCms\Core\Event\StaticEventManager
     */
    public function events()
    {
        return StaticEventManager::getInstance();
    }

    /**
     * Check user acl
     *
     * @param UserModel $userModel User model
     *
     * @return null
     */
    protected function checkAcl(UserModel $userModel)
    {
        if (!empty($this->aclPage) and $userModel->getRole()->getName() !== RoleModel::PROTECTED_NAME) {
            $permission = null;
            $acl        = $userModel->getAcl(true);
            if ($this->aclPage['resource'] == 'modules') {
                $moduleId = $this->getEvent()->getRouteMatch()->getParam('m');
                if (empty($moduleId)) {
                    $action     = $this->getEvent()->getRouteMatch()->getParam('action');
                    $permission = ($action === 'index' ? 'list' : $action);
                } else {
                    $moduleModel = ModuleModel::fromId($moduleId);
                    if (!empty($moduleModel)) {
                        $permission = $moduleModel->getName();
                    }
                }
            } else {
                $permission = empty($this->aclPage['permission']) ?
                    null :
                    $this->aclPage['permission'];
                if ($this->aclPage['permission'] != 'index' and
                    !in_array($this->aclPage['resource'], ['content', 'stats'])
                ) {
                    $action      = $this->getEvent()->getRouteMatch()->getParam('action');
                    $permission .= (!empty($permission) ? '/' : '') . ($action === 'index' ? 'list' : $action);
                }
            }

            if (!$acl->isAllowed(
                $userModel->getRole()->getName(),
                $this->aclPage['resource'],
                $permission
            )) {
                return $this->redirect()->toRoute('config/user/forbidden');
            }
        }
    }

    /**
     * Override aclPage property
     *
     * @param array $array Array for acl pages
     *
     * @return void
     */
    public function setAcl(array $array)
    {
        $this->aclPage = $array;
    }
    /**
     * Get session
     *
     * @return Session
     */
    public function getSession()
    {
        return $this->container->get('session');
    }

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
     * Get connected user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->getSession()->get('user');
    }

    /**
     * Get unauthorized response
     *
     * @param string $data Optional error message
     *
     * @return JsonResponse
     */
    public function unauthorized($data = null)
    {
        return $this->prepareResponse(Response::HTTP_UNAUTHORIZED, $data);
    }

    /**
     * Get unauthorized response
     *
     * @param mixed $data Optional error message
     *
     * @return JsonResponse
     */
    public function badRequest($data = null)
    {
        if ($data instanceof ConstraintViolationList) {
            $errors = [];
            foreach ($data as $error) {
                $errors[$error->getPropertyPath()] = $error->getMessage();
            }

            $data = $errors;
        }

        return $this->prepareResponse(Response::HTTP_BAD_REQUEST, $data);
    }

    /**
     * Get forbidden response
     *
     * @param string $data Optional error message
     *
     * @return JsonResponse
     */
    public function forbidden($data = null)
    {
        return $this->prepareResponse(Response::HTTP_FORBIDDEN, $data);
    }

    /**
     * Send json response
     *
     * @param integer $code HTTP code
     * @param string  $data Optional error message
     *
     * @return JsonResponse
     */
    protected function prepareResponse($code, $data = null)
    {
        $json = new JsonResponse([]);
        $json->setStatusCode($code);
        if (!empty($data)) {
            $json->setData($data);
        }

        return $json;
    }
}
