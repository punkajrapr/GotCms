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
 * @ORM\Table(name="user_acl_permission",
              indexes={
                @ORM\Index(name="fk_user_acl_permission_permission", columns={"permission"})
              })
 * @ORM\Entity(repositoryClass="GotCms\Core\Repository\UserAclPermissionRepository")
 */
class UserAclPermission extends BaseEntity
{
    /**
     * @ORM\Column(name="permission", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $permission;

    /**
     * @var UserAclResource
     *
     * @ORM\ManyToOne(targetEntity="UserAclResource")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_acl_resource_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $resource;

    /**
     * @var ArrayCollection UserAclRole $roles
     *
     * Inverse Side
     *
     * @ORM\ManyToMany(targetEntity="UserAclRole", mappedBy="permissions", cascade={"persist", "merge"})
     */
    private $roles;

    /**
     * Set permission
     *
     * @param string $permission Permission
     *
     * @return UserAclPermission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get permission
     *
     * @return string
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set resource
     *
     * @param UserAclResource $resource Resource
     *
     * @return UserAclPermission
     */
    public function setResource(UserAclResource $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return UserAclResource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * Add role
     *
     * @param UserAclRole $role Role
     *
     * @return UserAclPermission
     */
    public function addRole(UserAclRole $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param UserAclRole $role Role
     *
     * @return UserAclPermission
     */
    public function removeRole(UserAclRole $role)
    {
        $this->roles->removeElement($role);

        return $this;
    }

    /**
     * Get roles
     *
     * @return ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
