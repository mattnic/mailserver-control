<?php
    namespace App\Form;

    use App\Entity\Main\User;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Symfony\Component\Form\Extension\Core\Type\HiddenType;
    use Symfony\Component\Form\Extension\Core\Type\RadioType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Form\Extension\Core\Type\EmailType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
    use Symfony\Component\Form\Extension\Core\Type\PasswordType;

    class UserForm extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder->add('username', EmailType::class, [
                'label' => 'Email address',
                'attr'  => array('class' => 'form-control'),
            ]);


            $builder->add('firstName', TextType::class, [
                'attr'      => array('class' => 'form-control'),
                'required'  => false,
            ]);


            $builder->add('lastName', TextType::class, [
                'attr'  => array('class' => 'form-control'),
                'required'  => false,
            ]);


            $builder->add('roles', ChoiceType::class, [
                'label' => 'Account type',
                'multiple' => true,
                'choices' => [
                    'Standard user' => 'ROLE_USER',
                    'Administrator' => 'ROLE_ADMIN',
                ],
                'attr'  => array('class' => 'form-control'),
            ]);


            $builder->add('isEnabled', CheckboxType::class, [
                'required' => false,
            ]);


            if (!$options['data']->getId()):
                $builder->add('plainPassword', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options'  => [
                        'label'     => 'Password',
                        'attr'      => array('class' => 'form-control'),
                        'required'  => false,
                    ],
                    'second_options' => [
                        'label'     => 'Repeat Password',
                        'attr'      => array('class' => 'form-control'),
                        'required'  => false,
                    ],
                    'required'  => false,
                ]);
            else:
                $builder->add('plainPassword', HiddenType::class, [
                    'empty_data' => 'empty'
                ]);
            endif;




            $builder->add('submit', SubmitType::class, [
                'label' => 'Save and Close',
                'attr'  => array('class' => 'btn btn-primary'),
            ]);
        }


        /**
         * @param OptionsResolver $resolver
         */
        public function configureOptions(OptionsResolver $resolver)
        {
            $resolver->setDefaults(array(
                'data_class' => User::class,
            ));
        }
    }