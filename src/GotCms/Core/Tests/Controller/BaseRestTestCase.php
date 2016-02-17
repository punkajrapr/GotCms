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
 * @category   GotCms\Core\Tests
 * @package    GotCms\Core\Tests
 * @subpackage Controller
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */
namespace GotCms\Core\Tests\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Client;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Base test case controller
 *
 * @package    GotCms\Core\Tests
 * @subpackage Controller
 */
class BaseRestTestCase extends WebTestCase
{
    protected $client   = null;
    protected $fixtures = [];

    /**
     * Setup database and fixtures
     *
     * @return null
     */
    protected function setUp()
    {
        $this->runCommand('doctrine:schema:drop', ['--force' => true]);
        $this->runCommand('doctrine:schema:update', ['--force' => true]);

        $this->loadFixtures($this->fixtures);
    }

    /**
     * Get Game RestBundle repositories
     *
     * @return \GotCms\Core\Services\RepositoryService
     */
    protected function repos()
    {
        return $this->getContainer()->get('gotcms.repos');
    }

    /**
     * Get doctrine entity manager
     *
     * @return EntityManager
     */
    protected function em()
    {
        return $this->getDoctrine()->getEntityManager();
    }

    /**
     * Get Doctrine
     *
     * @return Registry
     */
    protected function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    /**
     * Serialize data
     *
     * @param mixed $data Data to serialize
     *
     * @return string
     */
    protected function serialize($data)
    {
        return $this->getContainer()->get('jms_serializer')->serialize($data, 'json');
    }

    /**
     * Get client
     *
     * @return Client
     */
    protected function getClient()
    {
        if (empty($this->client)) {
            $this->client = static::createClient();
        }

        return $this->client;
    }

    /**
     * Fake login
     *
     * @return User
     */
    protected function logIn()
    {
    }
}
