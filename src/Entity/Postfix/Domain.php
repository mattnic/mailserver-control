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
         * @ORM\Column(type="string", length=50)
         */
        private $name;


        public function getId()
        {
            return $this->id;
        }

        public function setName( $value )
        {
            $this->name = $value;
            return $this;
        }

        /**
         * Get domain name
         *
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

    }