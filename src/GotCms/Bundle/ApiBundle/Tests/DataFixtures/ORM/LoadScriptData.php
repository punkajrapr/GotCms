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
use GotCms\Core\Entity\Script;

/**
 * Load script data
 *
 * @package GotCms\Bundle\ApiBundle\Tests\DataFixtures
 */
class LoadScriptData extends AbstractFixture implements OrderedFixtureInterface
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
            $manager->persist($this->createScript('identifier-' . $i));
        }

        $manager->flush();
    }

    /**
     * Create new script
     *
     * @param string $identifier Identifier
     *
     * @return Script
     */
    protected function createScript($identifier)
    {
        $script = new Script();
        $script->setIdentifier($identifier);
        $script->setName($identifier);
        $script->setContent('content');
        $this->setReference('script' . ++$this->idx, $script);

        return $script;
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
