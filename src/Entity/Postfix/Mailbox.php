<?php
    namespace App\Entity\Postfix;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Table(name="`virtual_users`")
     * @ORM\Entity(repositoryClass="App\Repository\Postfix\MailboxRepository")
     */
    class Mailbox
    {
        /**
         * @ORM\Id
         * @ORM\GeneratedValue
         * @ORM\Column(type="integer")
         */
        private $id;

        /**
         * @ORM\ManyToOne(targetEntity="Domain", inversedBy="mailboxes")
         * @ORM\JoinColumn(name="domain_id", referencedColumnName="id")
         */
        private $domain;

        /**
         * @ORM\Column(type="string", length=100)
         */
        private $email;

        /**
         * @ORM\Column(type="string", length=106)
         */
        private $password;


        public function getId()
        {
            return $this->id;
        }

        /**
         * Set Domain
         *
         * @param Domain $domain
         * @return Mailbox
         */
        public function setServer(Domain $domain = null)
        {
            $this->domain = $domain;
            return $this;
        }

        /**
         * Get Domain
         *
         * @return Domain
         */
        public function getDomain()
        {
            return $this->domain;
        }

        /**
         * Set username
         *
         * @param string $value
         * @return Mailbox
         */
        public function setEmail( $value )
        {
            $this->email = $value;
            return $this;
        }

        /**
         * Get username
         *
         * @return string
         */
        public function getEmail()
        {
            return $this->email;
        }

        /**
         * Set password
         *
         * @param string $value
         * @return Mailbox
         */
        public function setPassword( $value )
        {
            $this->password = $value;
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

    }