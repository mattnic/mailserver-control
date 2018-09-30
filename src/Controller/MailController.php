<?php
    namespace App\Controller;

    use App\Entity\Postfix\Domain;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

    class MailController extends Controller
    {
        /**
         * @Route("/dashboard/mail", name="dash.mail.index")
         */
        public function index(Request $request, TokenStorageInterface $tokenStorage)
        {

            $id = 0;
            if (!$this->isGranted('ROLE_ADMIN')) {
                $user = $tokenStorage->getToken()->getUser();
                $id = $user->getId();
            }

            $query = $this->getDoctrine()
                ->getRepository(Domain::class, 'postfix')
                ->buildQuery($id);

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('p', 1),
                10
            );


            return $this->render('dashboard/mail/index.html.twig', [
                'results' => $pagination
            ]);
        }
    }