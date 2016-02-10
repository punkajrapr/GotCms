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
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Base Entity
 *
 * @package GotCms\Core
 * @MappedSuperclass()
 * @ORM\Table(name="property",
              indexes={
                @ORM\Index(name="fk_property_identifier", columns={"identifier"})
              })
 * @ORM\Entity(repositoryClass="GotCms\Core\Repository\PropertyRepository")
 * @UniqueEntity({"tab", "identifier"})
 */
class Property extends BaseEntity
{
    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(name="identifier", type="string", nullable=false, unique=true)
     * @Assert\NotBlank()
     * @Assert\Regex("~^[a-zA-Z0-9._-]+$~")
     */
    private $identifier;

    /**
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="required", type="boolean", nullable=false)
     */
    private $required;

    /**
     * @ORM\Column(name="order", type="integer", nullable=false)
     */
    private $order;

    /**
     * @var Tab
     *
     * @ORM\ManyToOne(targetEntity="Tab")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tab_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $tab;

    /**
     * @var Datatype
     *
     * @ORM\ManyToOne(targetEntity="Datatype")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="datatype_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $datatype;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Property
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
     * Set identifier
     *
     * @param string $identifier
     *
     * @return Property
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Property
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
     * Set required
     *
     * @param boolean $required
     *
     * @return Property
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Get required
     *
     * @return boolean
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Set order
     *
     * @param integer $order
     *
     * @return Property
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set tab
     *
     * @param \GotCms\Core\Entity\Tab $tab
     *
     * @return Property
     */
    public function setTab(\GotCms\Core\Entity\Tab $tab)
    {
        $this->tab = $tab;

        return $this;
    }

    /**
     * Get tab
     *
     * @return \GotCms\Core\Entity\Tab
     */
    public function getTab()
    {
        return $this->tab;
    }

    /**
     * Set datatype
     *
     * @param \GotCms\Core\Entity\Datatype $datatype
     *
     * @return Property
     */
    public function setDatatype(\GotCms\Core\Entity\Datatype $datatype)
    {
        $this->datatype = $datatype;

        return $this;
    }

    /**
     * Get datatype
     *
     * @return \GotCms\Core\Entity\Datatype
     */
    public function getDatatype()
    {
        return $this->datatype;
    }
}
