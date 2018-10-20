<?php
    namespace App\Repository\Postfix;

    use App\Entity\Postfix\Alias;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\ORM\Query\Expr\Join;
    use Symfony\Bridge\Doctrine\RegistryInterface;

    class AliasRepository extends ServiceEntityRepository
    {

        function findById( $aliasId, $user_id = 0)
        {

            $qb = $this->createQueryBuilder('f')
                ->select('f, d')
                ->leftJoin('App\Entity\Postfix\Domain','d', Join::WITH, 'd.id = f.domain');

                if ($user_id > 0) {
                    $qb = $qb->andWhere('f.id = :id');
                    $qb = $qb->setParameter('id', $aliasId);
                }

                if ($user_id > 0) {
                    $qb = $qb->andWhere('d.user = :user');
                    $qb = $qb->setParameter('user', $user_id);
                }

            $results = $qb->orderBy('f.source', 'ASC')
                ->getQuery()->getResult();

            return (isset($results[0]))? $results[0] : $results;
        }


        function buildQuery($user_id = 0)
        {

            $qb = $this->createQueryBuilder('f')
                ->select('f, d')
                ->leftJoin('f.domain','d');

                if ($user_id > 0) {
                    $qb = $qb->andWhere('d.user = :user');
                    $qb = $qb->setParameter('user', $user_id);
                }

            $qb = $qb->addOrderBy('f.name', 'ASC')
                ->getQuery();

            return $qb;
        }




        public function __construct(RegistryInterface $registry)
        {
            parent::__construct($registry, Alias::class);
        }
    }