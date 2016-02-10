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
 * @category   GotCms\Core
 * @package    GotCms\Core
 * @subpackage EventListener
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */
namespace GotCms\Core\EventListener;

use Symfony\Component\Filesystem\Filesystem;
use GotCms\Core\Entity\BaseTemplateEntity;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\Container;

/**
 * Base Entity
 *
 * @package    GotCms\Core
 * @subpackage EventListener
 */
class SaveContent
{
    protected $container;

    /**
     * Set container
     *
     * @param Container $container Container
     *
     * @return null
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Post remove handler
     *
     * @param LifecycleEventArgs $event Lifecycle event args
     *
     * @return null
     */
    public function postRemove(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();
        if (!$entity instanceof BaseTemplateEntity) {
            return;
        }

        $fs       = new Filesystem();
        $filePath = $this->getTemplatePath($entity->getType(), $entity->getIdentifier());
        if ($fs->exists($filePath)) {
            $fs->remove($filePath);
        }
    }

    /**
     * Post update handler
     *
     * @param LifecycleEventArgs $event Lifecycle event args
     *
     * @return null
     */
    public function postUpdate(LifecycleEventArgs $event)
    {
        $this->checkForFile($event);
    }

    /**
     * Post persist handler
     *
     * @param LifecycleEventArgs $event Lifecycle event args
     *
     * @return null
     */
    public function postPersist(LifecycleEventArgs $event)
    {
        $this->checkForFile($event);
    }

    /**
     * Post load handler
     *
     * @param LifecycleEventArgs $event Lifecycle event args
     *
     * @return null
     */
    public function postLoad(LifecycleEventArgs $event)
    {
        $this->checkForFile($event, true);
    }

    /**
     * Check for file
     *
     * @param LifecycleEventArgs $event Lifecycle event args
     * @param boolean            $read  Is reading or writing
     *
     * @return BaseTemplateEntity
     */
    protected function checkForFile(LifecycleEventArgs $event, $read = false)
    {
        $entity = $event->getEntity();
        if (!$entity instanceof BaseTemplateEntity) {
            return;
        }

        $fs       = new Filesystem();
        $filePath = $this->getTemplatePath($entity->getType(), $entity->getIdentifier());

        if ($read) {
            return $entity->setContent(file_get_contents($filePath));
        }

        $changes = $event->getObjectManager()->getUnitOfWork()->getEntityChangeSet($entity);
        if (!empty($changes['identifier'][0])) {
            $fs->rename(
                $this->getTemplatePath($entity->getType(), $changes['identifier'][0]),
                $filePath
            );
        }

        $fs->dumpFile($filePath, $entity->getContent());
        return $entity;
    }

    /**
     * Get template path
     *
     * @param string $type       Type
     * @param string $identifier Identifier
     *
     * @return string
     */
    protected function getTemplatePath($type, $identifier)
    {
        $templatePath = $this->container->getParameter('gotcms_api.templates_path');
        return sprintf(
            '%s/%ss/%s.phtml',
            $templatePath,
            $type,
            $identifier
        );
    }
}
