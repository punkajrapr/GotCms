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
 * @ORM\Table(name="log_visitor",
              indexes={
                @ORM\Index(name="fk_log_visitor_session_id", columns={"session_id"})
              })
 * @ORM\Entity(repositoryClass="GotCms\Core\Repository\VisitorRepository")
 */
class Visitor extends BaseEntity
{
    /**
     * @ORM\Column(name="session_id", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $sessionId;

    /**
     * @ORM\Column(name="http_user_agent", type="string", nullable=true)
     */
    private $httpUserAgent;

    /**
     * @ORM\Column(name="http_accept_charset", type="string", nullable=true)
     */
    private $httpAcceptCharset;

    /**
     * @ORM\Column(name="http_accept_language", type="string", nullable=true)
     */
    private $httpAcceptLanguage;

    /**
     * @ORM\Column(name="server_addr", type="bigint", nullable=true)
     */
    private $serverAddr;

    /**
     * @ORM\Column(name="remote_addr", type="bigint", nullable=true)
     */
    private $remoteAddr;

    /**
     * Set sessionId
     *
     * @param string $sessionId Session id
     *
     * @return Visitor
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * Get sessionId
     *
     * @return string
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set httpUserAgent
     *
     * @param string $httpUserAgent HTTP User agent
     *
     * @return Visitor
     */
    public function setHttpUserAgent($httpUserAgent)
    {
        $this->httpUserAgent = $httpUserAgent;

        return $this;
    }

    /**
     * Get httpUserAgent
     *
     * @return string
     */
    public function getHttpUserAgent()
    {
        return $this->httpUserAgent;
    }

    /**
     * Set httpAcceptCharset
     *
     * @param string $httpAcceptCharset HTTP Accept charset
     *
     * @return Visitor
     */
    public function setHttpAcceptCharset($httpAcceptCharset)
    {
        $this->httpAcceptCharset = $httpAcceptCharset;

        return $this;
    }

    /**
     * Get httpAcceptCharset
     *
     * @return string
     */
    public function getHttpAcceptCharset()
    {
        return $this->httpAcceptCharset;
    }

    /**
     * Set httpAcceptLanguage
     *
     * @param string $httpAcceptLanguage HTTP Accept language
     *
     * @return Visitor
     */
    public function setHttpAcceptLanguage($httpAcceptLanguage)
    {
        $this->httpAcceptLanguage = $httpAcceptLanguage;

        return $this;
    }

    /**
     * Get httpAcceptLanguage
     *
     * @return string
     */
    public function getHttpAcceptLanguage()
    {
        return $this->httpAcceptLanguage;
    }

    /**
     * Set serverAddr
     *
     * @param integer $serverAddr Server addr
     *
     * @return Visitor
     */
    public function setServerAddr($serverAddr)
    {
        $this->serverAddr = $serverAddr;

        return $this;
    }

    /**
     * Get serverAddr
     *
     * @return integer
     */
    public function getServerAddr()
    {
        return $this->serverAddr;
    }

    /**
     * Set remoteAddr
     *
     * @param integer $remoteAddr Remote addr
     *
     * @return Visitor
     */
    public function setRemoteAddr($remoteAddr)
    {
        $this->remoteAddr = $remoteAddr;

        return $this;
    }

    /**
     * Get remoteAddr
     *
     * @return integer
     */
    public function getRemoteAddr()
    {
        return $this->remoteAddr;
    }
}
