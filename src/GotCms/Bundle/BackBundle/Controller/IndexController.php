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
 * @package    BackBundle
 * @subpackage Controller
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */
namespace GotCms\Bundle\BackBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Index Controller
 *
 * @category   GotCms\Bundle
 * @package    BackBundle
 * @subpackage Controller
 */
class IndexController extends Controller
{
    /**
     * Index action when using /, tricks to use / or not when
     * requesting /admin
     *
     * @Route ("/")
     *
     * @return null
     */
    public function indexAction()
    {
        return $this->allAction('');
    }

    /**
     * Default action
     *
     * @param string $path Path
     *
     * @Route("/{path}", requirements={"path"=".*"})
     *
     * @return null
     */
    public function allAction($path)
    {
        return $this->render('GotCmsBackBundle:index.html.twig');
    }
}
