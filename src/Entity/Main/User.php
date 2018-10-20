<?php
    namespace App\Entity\Main;

    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;
    use Symfony\Component\Security\Core\User\AdvancedUserInterface;

    /**
     * @ORM\Table(name="`users`")
     * @ORM\Entity(repositoryClass="App\Repository\Main\UserRepository")
     */
    class User implements AdvancedUserInterface, \Serializable
    {
        /**
         * @ORM\Column(type="integer")
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        private $id;

        /**
         * @ORM\Column(type="string", length=254, unique=true)
         */
        private $username;

        /**
         * @ORM\Column(type="string", length=64)
         */
        private $password;

        /**
         * @Assert\NotBlank()
         * @Assert\Length(max=4096)
         */
        private $plainPassword;

        /**
         * @ORM\Column(type="string", length=254, nullable=true)
         */
        private $firstName;

        /**
         * @ORM\Column(type="string", length=254, nullable=true)
         */
        private $lastName;

        /**
         * @ORM\Column(type="array")
         */
        private $roles;

        /**
         * @ORM\Column(name="is_active", type="boolean")
         */
        private $isActive;


        public function __construct()
        {
            $this->isActive = true;

            $this->roles = array('ROLE_USER');
        }


        public function getId()
        {
            return $this->id;
        }


        public function setUsername($username)
        {
            $this->username = $username;
        }

        public function getUsername()
        {
            return $this->username;
        }


        public function setPassword($password)
        {
            $this->password = $password;
        }

        public function getPassword()
        {
            return $this->password;
        }


        public function setPlainPassword($password)
        {
            $this->plainPassword = $password;
        }

        public function getPlainPassword()
        {
            return $this->plainPassword;
        }


        public function setFirstName($value)
        {
            $this->password = $value;
        }

        public function getFirstName()
        {
            return $this->firstName;
        }


        public function setLastName($value)
        {
            $this->password = $value;
        }

        public function getLastName()
        {
            return $this->lastName;
        }

        public function getFullName()
        {
            return trim($this->firstName .' '. $this->lastName);
        }


        public function getRoles()
        {
            $roles = array_merge(['ROLE_USER'], $this->roles);

            return $roles;
        }


        public function isAccountNonExpired()
        {
            return true;
        }

        public function isAccountNonLocked()
        {
            return true;
        }

        public function isCredentialsNonExpired()
        {
            return true;
        }

        public function isEnabled()
        {
            return $this->isActive;
        }

        public function eraseCredentials()
        {
        }

        public function getSalt()
        {
            return null;
        }


        /** @see \Serializable::serialize() */
        public function serialize()
        {
            return serialize(array(
                $this->id,
                $this->username,
                $this->password,
                $this->isActive,
            ));
        }

        /** @see \Serializable::unserialize() */
        public function unserialize($serialized)
        {
            list (
                $this->id,
                $this->username,
                $this->password,
                $this->isActive,
            ) = unserialize($serialized, array('allowed_classes' => false));
        }
    }