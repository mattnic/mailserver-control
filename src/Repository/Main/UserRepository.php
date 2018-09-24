<?php
    namespace App\Repository\Main;

    use App\Entity\Main\User;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Symfony\Bridge\Doctrine\RegistryInterface;

    class UserRepository extends ServiceEntityRepository
    {


        public function __construct(RegistryInterface $registry)
        {
            parent::__construct($registry, User::class);
        }
    }