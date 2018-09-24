<?php
    namespace App\Controller;

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

    }
