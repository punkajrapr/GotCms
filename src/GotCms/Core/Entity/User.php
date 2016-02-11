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
 * @ORM\Table(name="user",
              indexes={
                @ORM\Index(name="fk_user_login", columns={"login"}),
                @ORM\Index(name="fk_user_email", columns={"email"})
              })
 * @ORM\Entity(repositoryClass="GotCms\Core\Repository\UserRepository")
 * @UniqueEntity("login")
 * @UniqueEntity("email")
 */
class User extends BaseEntity
{
    /**
     * @ORM\Column(name="login", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $login;

    /**
     * @ORM\Column(name="email", type="string", nullable=false)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(name="firstname", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", nullable=false)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @ORM\Column(name="password", type="string", nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min="4")
     */
    private $password;

    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     * @Assert\Type("boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="retrieve_password_key", type="string", nullable=true)
     * @Assert\NotBlank()
     */
    private $retrievePasswordKey;

    /**
     * @ORM\Column(name="retrieve_password_date", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $retrievePasswordDate;

    /**
     * Set login
     *
     * @param string $login Login
     *
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set email
     *
     * @param string $email Email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set firstname
     *
     * @param string $firstname Firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname Lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set password
     *
     * @param string $password Password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive Is active
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set retrievePasswordKey
     *
     * @param string $retrievePasswordKey Retrieve password key
     *
     * @return User
     */
    public function setRetrievePasswordKey($retrievePasswordKey)
    {
        $this->retrievePasswordKey = $retrievePasswordKey;

        return $this;
    }

    /**
     * Get retrievePasswordKey
     *
     * @return string
     */
    public function getRetrievePasswordKey()
    {
        return $this->retrievePasswordKey;
    }

    /**
     * Set retrievePasswordDate
     *
     * @param DateTime $retrievePasswordDate Retrieve password date
     *
     * @return User
     */
    public function setRetrievePasswordDate(DateTime $retrievePasswordDate)
    {
        $this->retrievePasswordDate = $retrievePasswordDate;

        return $this;
    }

    /**
     * Get retrievePasswordDate
     *
     * @return DateTime
     */
    public function getRetrievePasswordDate()
    {
        return $this->retrievePasswordDate;
    }
}
