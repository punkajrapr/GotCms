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
use GotCms\Core\Entity\Layout;

/**
 * Load layout data
 *
 * @package GotCms\Bundle\ApiBundle\Tests\DataFixtures
 */
class LoadLayoutData extends AbstractFixture implements OrderedFixtureInterface
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
            $manager->persist($this->createLayout('identifier-' . $i));
        }

        $manager->flush();
    }

    /**
     * Create new layout
     *
     * @param string $identifier Identifier
     *
     * @return Layout
     */
    protected function createLayout($identifier)
    {
        $layout = new Layout();
        $layout->setIdentifier($identifier);
        $layout->setName($identifier);
        $layout->setContent('content');
        $this->setReference('layout' . ++$this->idx, $layout);

        return $layout;
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
