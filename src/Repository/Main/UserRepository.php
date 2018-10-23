<?php
    namespace App\Repository\Main;

    use App\Entity\Main\User;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Symfony\Bridge\Doctrine\RegistryInterface;

    class UserRepository extends ServiceEntityRepository
    {

        /**
         * UserRepository constructor.
         *
         * @param RegistryInterface $registry
         */
        public function __construct(RegistryInterface $registry)
        {
            parent::__construct($registry, User::class);
        }


        /**
         * @return \Doctrine\ORM\Query
         */
        function buildQuery()
        {

            $qb = $this
                ->createQueryBuilder('u')
                ->orderBy('u.username', 'ASC')
                ->getQuery();

            return $qb;
        }
    }