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
 * @category   GotCms\Bundle\ApiBundle\Tests\DataFixtures
 * @package    GotCms\Bundle\ApiBundle\Tests\DataFixtures
 * @subpackage ORM
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */
namespace GotCms\Bundle\ApiBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use GotCms\Core\Entity\View;

/**
 * Load view data
 *
 * @package GotCms\Bundle\ApiBundle\Tests\DataFixtures
 */
class LoadViewData extends AbstractFixture implements OrderedFixtureInterface
{
    protected $idx = 0;

    /**
     * Load fixture
     *
     * @param ObjectManager $manager Object manager
     *
     * @return null
     */
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i<5; $i++) {
            $manager->persist($this->createView('identifier-' . $i));
        }

        $manager->flush();
    }

    /**
     * Create new view
     *
     * @param string $identifier Identifier
     *
     * @return View
     */
    protected function createView($identifier)
    {
        $view = new View();
        $view->setIdentifier($identifier);
        $view->setName($identifier);
        $view->setContent('content');
        $this->setReference('view' . ++$this->idx, $view);

        return $view;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 0;
    }
}
