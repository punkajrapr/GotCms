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
 * @subpackage Entity\Log
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */
namespace GotCms\Core\Entity\Log;

use GotCms\Core\Entity\BaseEntity;
use DateTime;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Base Entity
 *
 * @package    GotCms\Core
 * @subpackage Entity\Log
 * @MappedSuperclass()
 * @ORM\Table(name="log_url")
 * @ORM\Entity(repositoryClass="GotCms\Core\Repository\VisitorRepository")
 */
class Url extends BaseEntity
{
    /**
     * @ORM\Column(name="visit_at", type="datetime", nullable=false)
     */
    private $visitAt;

    /**
     * @var UrlInfo
     *
     * @ORM\ManyToOne(targetEntity="UrlInfo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="log_url_info_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $urlInfo;

    /**
     * @var Visitor
     *
     * @ORM\ManyToOne(targetEntity="Visitor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="log_visitor_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $visitor;

    /**
     * Set visitAt
     *
     * @param \DateTime $visitAt Visit at
     *
     * @return Url
     */
    public function setVisitAt($visitAt)
    {
        $this->visitAt = $visitAt;

        return $this;
    }

    /**
     * Get visitAt
     *
     * @return \DateTime
     */
    public function getVisitAt()
    {
        return $this->visitAt;
    }

    /**
     * Set urlInfo
     *
     * @param UrlInfo $urlInfo Url information
     *
     * @return Url
     */
    public function setUrlInfo(UrlInfo $urlInfo)
    {
        $this->urlInfo = $urlInfo;

        return $this;
    }

    /**
     * Get urlInfo
     *
     * @return UrlInfo
     */
    public function getUrlInfo()
    {
        return $this->urlInfo;
    }

    /**
     * Set visitor
     *
     * @param Visitor $visitor Visitor
     *
     * @return Url
     */
    public function setVisitor(Visitor $visitor)
    {
        $this->visitor = $visitor;

        return $this;
    }

    /**
     * Get visitor
     *
     * @return Visitor
     */
    public function getVisitor()
    {
        return $this->visitor;
    }
}
