<?php
    namespace App\Repository\Postfix;

    use App\Entity\Postfix\Domain;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Symfony\Bridge\Doctrine\RegistryInterface;

    class DomainRepository extends ServiceEntityRepository
    {

        



        public function __construct(RegistryInterface $registry)
        {
            parent::__construct($registry, Domain::class);
        }
    }