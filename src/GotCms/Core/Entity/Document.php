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
 * @ORM\Table(name="document",
              indexes={
                @ORM\Index(name="fk_document_name", columns={"name"}),
                @ORM\Index(name="fk_document_url_key", columns={"url_key"})
              })
 * @ORM\Entity(repositoryClass="GotCms\Core\Repository\DocumentRepository")
 */
class Document extends BaseEntity
{
    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(name="url_key", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $urlKey;

    /**
     * @ORM\Column(name="status", type="integer", nullable=false, options={"default": 0})
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * @ORM\Column(name="order", type="integer", nullable=false, options={"default": 0})
     * @Assert\NotBlank()
     */
    private $order;

    /**
     * @ORM\Column(name="show_in_nav", type="boolean", nullable=false, options={"default": false})
     * @Assert\Type("boolean")
     */
    private $showInNav;

    /**
     * @ORM\Column(name="can_be_cached", type="boolean", nullable=false, options={"default": false})
     * @Assert\Type("boolean")
     */
    private $canBeCached;

    /**
     * @ORM\Column(name="locale", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    private $locale;

    /**
     * @var View
     *
     * @ORM\ManyToOne(targetEntity="View")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="view_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $view;

    /**
     * @var Layout
     *
     * @ORM\ManyToOne(targetEntity="Layout")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="layout_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $layout;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $user;

    /**
     * @var DocumentType
     *
     * @ORM\ManyToOne(targetEntity="DocumentType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="document_type_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $documentType;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Document")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $parent;

    /**
     * Set name
     *
     * @param string $name Name
     *
     * @return Document
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
     * Set urlKey
     *
     * @param string $urlKey Url key
     *
     * @return Document
     */
    public function setUrlKey($urlKey)
    {
        $this->urlKey = $urlKey;

        return $this;
    }

    /**
     * Get urlKey
     *
     * @return string
     */
    public function getUrlKey()
    {
        return $this->urlKey;
    }

    /**
     * Set status
     *
     * @param integer $status Status
     *
     * @return Document
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set order
     *
     * @param integer $order Order
     *
     * @return Document
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
     * Set showInNav
     *
     * @param boolean $showInNav Show in nav
     *
     * @return Document
     */
    public function setShowInNav($showInNav)
    {
        $this->showInNav = $showInNav;

        return $this;
    }

    /**
     * Get showInNav
     *
     * @return boolean
     */
    public function getShowInNav()
    {
        return $this->showInNav;
    }

    /**
     * Set canBeCached
     *
     * @param boolean $canBeCached Can be cached
     *
     * @return Document
     */
    public function setCanBeCached($canBeCached)
    {
        $this->canBeCached = $canBeCached;

        return $this;
    }

    /**
     * Get canBeCached
     *
     * @return boolean
     */
    public function getCanBeCached()
    {
        return $this->canBeCached;
    }

    /**
     * Set locale
     *
     * @param string $locale Locale
     *
     * @return Document
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set view
     *
     * @param View $view View
     *
     * @return Document
     */
    public function setView(View $view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get view
     *
     * @return View
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set layout
     *
     * @param Layout $layout Layout
     *
     * @return Document
     */
    public function setLayout(Layout $layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get layout
     *
     * @return Layout
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Set user
     *
     * @param User $user User
     *
     * @return Document
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set documentType
     *
     * @param DocumentType $documentType Document type
     *
     * @return Document
     */
    public function setDocumentType(DocumentType $documentType)
    {
        $this->documentType = $documentType;

        return $this;
    }

    /**
     * Get documentType
     *
     * @return DocumentType
     */
    public function getDocumentType()
    {
        return $this->documentType;
    }

    /**
     * Set parent
     *
     * @param Document $parent Parent document
     *
     * @return Document
     */
    public function setParent(Document $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Document
     */
    public function getParent()
    {
        return $this->parent;
    }
}
