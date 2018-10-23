<?php
    namespace App\Form;

    use App\Entity\Postfix\Alias;
    use App\Entity\Postfix\Domain;
    use App\Repository\Postfix\DomainRepository;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\EmailType;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;

    class AliasForm extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {

            $builder->add('name', TextType::class, [
                'label' => 'Name',
                'attr'  => array('class' => 'form-control'),
            ]);

            if (!isset($options['data']->domain)):
                $builder->add('domain', EntityType::class, [
                    'label' => 'Name',
                    'attr'  => array('class' => 'form-control'),

                    'class' => Domain::class,
                    'query_builder' => function (DomainRepository $er) {
                        global $options;
                         $qb = $er->createQueryBuilder('d')
                            ->orderBy('d.name', 'asc');

                         if (isset($options['user']) && $options['user'] > 0) {
                             $qb->where('d.user = :user');
                             $qb->setParameter('user', $options['user']);
                         }


                        return $qb;
                    },
                    'placeholder' => ' - Choose a domain name - ',
                    'choice_label' => 'name',
                ]);
            endif;

            $builder->add('destination', EmailType::class, [
                'attr'  => array('class' => 'form-control'),
            ]);

            $builder->add('submit', SubmitType::class, [
                'label' => 'Save and Close',
                'attr'  => array('class' => 'btn btn-primary'),
            ]);

        }

        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults(array(
                'user' => 0,
                'data_class' => Alias::class,
            ));
        }
    }