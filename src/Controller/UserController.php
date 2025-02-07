<?php
    namespace App\Controller;

    use App\Form\UserForm;
    use App\Entity\Main\User;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

    class UserController extends AbstractController
    {
        /**
         * @Route("/sign", name="user.signin")
         */
        public function sign()
        {

            return $this->render('user/signin.html.twig', [
                'results' => []
            ]);

        }


        /**
         * @Route("/register", name="user_registration")
         */
        public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
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

            return $this->render(
                'user/register.html.twig',
                array('form' => $form->createView())
            );
        }
    }