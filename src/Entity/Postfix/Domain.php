<?php
    namespace App\Entity\Postfix;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Table(name="`virtual_domains`")
     * @ORM\Entity(repositoryClass="App\Repository\Postfix\DomainRepository")
     */
    class Domain
    {
        /**
         * @ORM\Id
         * @ORM\GeneratedValue
         * @ORM\Column(type="integer")
         */
        private $id;

        /**
         * @ORM\Column(type="integer")
         */
        private $user;

        /**
         * @ORM\Column(type="string", length=50)
         */
        private $name;

        /**
         * @ORM\OneToMany(targetEntity="Mailbox", mappedBy="domain", fetch="EXTRA_LAZY")
         */
        private $mailboxes;

        /**
         * @ORM\OneToMany(targetEntity="Alias", mappedBy="domain", fetch="EXTRA_LAZY")
         */
        private $aliases;


        public function getId()
        {
            return $this->id;
        }


        /**
         * Set User ID
         *
         * @param integer
         * @return Domain
         */
        public function setUser( $value )
        {
            $this->user = $value;
            return $this;
        }

        /**
         * Get User ID
         *
         * @return integer
         */
        public function getUser()
        {
            return $this->user;
        }


        /**
         * Set domain name
         *
         * @param string
         * @return Domain
         */
        public function setName( $value )
        {
            $this->name = $value;
            return $this;
        }

        /**
         * Get Domain Name
         *
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }


        /**
         * Add Mailbox
         *
         * @param Mailbox $mailbox
         * @return Domain
         */
        public function addMailboxes(Mailbox $mailbox)
        {
            $this->mailboxes[] = $mailbox;
            return $this;
        }

        /**
         * Remove Mailbox
         *
         * @param Mailbox $mailbox
         */
        public function removeMailboxes(Mailbox $mailbox)
        {
            $this->mailboxes->removeElement($mailbox);
        }

        /**
         * Get Mailboxes
         *
         * @return \Doctrine\Common\Collections\Collection
         */
        public function getMailboxes()
        {
            return $this->mailboxes;
        }


        /**
         * Add Alias
         *
         * @param Alias $alias
         * @return Domain
         */
        public function addAlias(Alias $alias)
        {
            $this->aliases[] = $alias;
            return $this;
        }

        /**
         * Remove Alias
         *
         * @param Alias $alias
         */
        public function removeAlias(Alias $alias)
        {
            $this->aliases->removeElement($alias);
        }

        /**
         * Get Mailboxes
         *
         * @return \Doctrine\Common\Collections\Collection
         */
        public function getAliases()
        {
            return $this->aliases;
        }

    }