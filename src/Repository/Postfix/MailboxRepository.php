<?php
    namespace App\Repository\Postfix;

    use App\Entity\Postfix\Mailbox;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\ORM\Query\Expr\Join;
    use Symfony\Bridge\Doctrine\RegistryInterface;

    class MailboxRepository extends ServiceEntityRepository
    {

        function buildQuery($user_id = 0)
        {

            $qb = $this->createQueryBuilder('m')
                ->select('m.id, m.email, d.name')
                ->leftJoin('App\Entity\Postfix\Domain','d', Join::WITH, 'd.id = m.domain');

                if ($user_id > 0) {
                    $qb = $qb->andWhere('d.user = :user');
                    $qb = $qb->setParameter('user', $user_id);
                }

            $qb = $qb->orderBy('m.email', 'ASC')
                ->getQuery();

            return $qb;
        }
        



        public function __construct(RegistryInterface $registry)
        {
            parent::__construct($registry, Mailbox::class);
        }
    }