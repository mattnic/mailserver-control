<?php
    namespace App\Controller;

    use App\Entity\Main\User;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
    use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class SecurityController extends AbstractController
    {
        /**
         * @Route("/signin", name="signin")
         *
         * @param AuthenticationUtils $authenticationUtils
         * @return Response
         */
        public function signin(AuthenticationUtils $authenticationUtils)
        {
            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();

            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();


            return $this->render('user/signin.html.twig', [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]);
        }


        /**
         * @Route("/register", name="tmp")
         */
        public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
        {

            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository(User::class)->find(1);

            $user->setPlainPassword('creative');
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute('signin');
        }

    }
