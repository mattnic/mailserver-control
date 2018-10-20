<?php
    namespace App\Entity\Postfix;

    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Table(name="`virtual_aliases`")
     * @ORM\Entity(repositoryClass="App\Repository\Postfix\AliasRepository")
     */
    class Alias
    {
        /**
         * @ORM\Id
         * @ORM\GeneratedValue
         * @ORM\Column(type="integer")
         */
        private $id;

        /**
         * @ORM\ManyToOne(targetEntity="Domain", inversedBy="aliases")
         * @ORM\JoinColumn(name="domain_id", referencedColumnName="id")
         */
        private $domain;

        /**
         * @ORM\Column(type="string", length=100)
         */
        private $name;

        /**
         * @ORM\Column(type="string", length=100, nullable=true)
         */
        private $source;

        /**
         * @ORM\Column(type="string", length=100)
         */
        private $destination;


        public function getId()
        {
            return $this->id;
        }

        /**
         * Set Domain
         *
         * @param Domain $domain
         * @return Alias
         */
        public function setDomain(Domain $domain = null)
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
         * Set Email Name
         *
         * @param string $value
         * @return Alias
         */
        public function setName( $value )
        {
            $this->name = $value;
            return $this;
        }

        /**
         * Get Email Name
         *
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }


        /**
         * Set Domain
         *
         * @param string $value
         * @return Alias
         */
        public function setSource( $value )
        {
            $this->source = $value;
            return $this;
        }

        /**
         * Get Domain
         *
         * @return string
         */
        public function getSource()
        {
            return $this->source;
        }


        /**
         * Set source email address
         *
         * @param string $value
         * @return Alias
         */
        public function setDestination( $value )
        {
            $this->destination = $value;
            return $this;
        }

        /**
         * Get destination email address
         *
         * @return string
         */
        public function getDestination()
        {
            return $this->destination;
        }

    }