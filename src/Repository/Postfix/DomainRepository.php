<?php
    namespace App\Repository\Postfix;

    use App\Entity\Postfix\Domain;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Symfony\Bridge\Doctrine\RegistryInterface;

    class DomainRepository extends ServiceEntityRepository
    {

        function buildQuery($user_id = 0)
        {
            $sub_mailbox = '(SELECT COUNT(m.id) FROM App\Entity\Postfix\Mailbox as m WHERE m.domain = d.id)';
            $sub_alias = '(SELECT COUNT(a.id) FROM App\Entity\Postfix\Alias as a WHERE a.domain = d.id)';


            $qb = $this->createQueryBuilder('d')
                ->select('d.id, d.name')
                ->addSelect($sub_mailbox.' as num_mailbox')
                ->addSelect($sub_alias.' as num_alias');

                if ($user_id > 0) {
                    $qb = $qb->andWhere('d.user = :user');
                    $qb = $qb->setParameter('user', $user_id);
                }

            $qb = $qb->orderBy('d.name', 'ASC')
                ->getQuery();

            return $qb;
        }
        



        public function __construct(RegistryInterface $registry)
        {
            parent::__construct($registry, Domain::class);
        }
    }