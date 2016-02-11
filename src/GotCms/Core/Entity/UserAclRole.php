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
 * @subpackage Entity
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */
namespace GotCms\Core\Entity;

use DateTime;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Base Entity
 *
 * @package GotCms\Core
 * @MappedSuperclass()
 * @ORM\Table(name="user_acl_role",
              indexes={
                @ORM\Index(name="fk_user_name", columns={"name"})
              })
 * @ORM\Entity(repositoryClass="GotCms\Core\Repository\UserAclRoleRepository")
 * @UniqueEntity("name")
 */
class UserAclRole extends BaseEntity
{
    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(name="description", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $description;


    /**
     * @var ArrayCollection UserAclPermission $permissions
     * Owning Side
     *
     * @ORM\ManyToMany(targetEntity="UserAclPermission", inversedBy="roles", cascade={"persist", "merge"})
     * @ORM\JoinTable(name="user_acl",
     *   joinColumns={@ORM\JoinColumn(name="user_acl_role_id", referencedColumnName="id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="user_acl_permission_id", referencedColumnName="id")}
     * )
     */
    private $permissions;

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return UserAclRole
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description Description
     *
     * @return UserAclRole
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->permissions = new ArrayCollection();
    }

    /**
     * Add permission
     *
     * @param UserAclPermission $permission Permission
     *
     * @return UserAclRole
     */
    public function addPermission(UserAclPermission $permission)
    {
        $this->permissions[] = $permission;

        return $this;
    }

    /**
     * Remove permission
     *
     * @param UserAclPermission $permission Permission
     *
     * @return UserAclRole
     */
    public function removePermission(UserAclPermission $permission)
    {
        $this->permissions->removeElement($permission);

        return $this;
    }

    /**
     * Get permissions
     *
     * @return ArrayCollection
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
}
