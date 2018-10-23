<?php
    namespace App\Controller;

    use App\Form\PasswordForm;
    use App\Form\UserForm;
    use App\Entity\Main\User;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

    class UserController extends Controller
    {
        private $em;

        private $repo;

        public function __construct(EntityManagerInterface $entityManager)
        {
            $this->em = $entityManager;

            $this->repo = $entityManager->getRepository(User::class);
        }


        /**
         * @Route("/dashboard/user", name="dash.user.index")
         */
        public function domainList(Request $request)
        {
            $query = $this->repo->buildQuery();

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('p', 1),
                10
            );


            return $this->render('dashboard/user/index.html.twig', [
                'results' => $pagination
            ]);
        }


        /**
         * @Route("/dashboard/user/add", name="dash.user.add")
         */
        public function add(Request $request, UserPasswordEncoderInterface $passwordEncoder)
        {
            // 1) build the form
            $user = new User();
            $form = $this->createForm(UserForm::class, $user);

            // 2) handle the submit (will only happen on POST)
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                // 4) save the User!
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                // ... do any other work - like sending them an email, etc
                // maybe set a "flash" success message for the user

                return $this->redirectToRoute('dash.index');
            }


            return $this->render('dashboard/user/edit.html.twig', [
                'item'      => null,
                'userform'  => $form->createView(),
            ]);
        }


        /**
         * @Route("/dashboard/user/{id}/edit", name="dash.user.edit")
         */
        public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder, $id)
        {

            // 1) build the form
            $details = $this->repo->find( $id );


            $userform = $this->createForm(UserForm::class, $details);
            $userform->handleRequest($request);
            if ($userform->isSubmitted()) {
                if ($userform->isValid()) {

                    $this->em->persist($details);
                    $this->em->flush();

                    return $this->redirectToRoute('dash.user.index');
                }
            }


            $password = $this->createForm(PasswordForm::class, $details);
            $password->handleRequest($request);
            if ($password->isSubmitted()) {
                if ($password->isValid()) {

                    $password = $passwordEncoder->encodePassword($details, $details->getPlainPassword());
                    $details->setPassword($password);

                    $this->em->persist($details);
                    $this->em->flush();

                    return $this->redirectToRoute('dash.user.index');
                }
            }


            return $this->render('dashboard/user/edit.html.twig', [
                'item'      => $details,
                'userform'  => $userform->createView(),
                'password'  => $password->createView(),
            ]);
        }
    }