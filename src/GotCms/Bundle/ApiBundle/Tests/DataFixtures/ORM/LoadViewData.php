<?php
/**
 * Datafixtures ORM
 *
 * PHP version >= 5.5
 *
 * @category   GotCms\Bundle\ApiBundle\Tests
 * @package    GotCms\Bundle\ApiBundle\Tests\DataFixtures
 * @subpackage ORM
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       https://www.prettysimplegames.com/
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
