<?php
    namespace App\Controller;

    use App\Entity\Postfix\Alias;
    use App\Entity\Postfix\Domain;
    use App\Entity\Postfix\Mailbox;
    use App\Form\AliasForm;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

    class MailController extends Controller
    {
        private $token = null;

        private $user = null;

        private $filterID = 0;

        function __construct(TokenStorageInterface $tokenStorage)
        {
            $this->token = $tokenStorage;

            $this->user = $tokenStorage->getToken()->getUser();

        }


        private function getFilterId()
        {
            if (!$this->isGranted('ROLE_ADMIN')) {
                $this->filterID = $this->user->getId();
            }
        }


        /**
         * @Route("/dashboard/mail", name="dash.mail.index")
         */
        public function index()
        {

        }


        /**
         * @Route("/dashboard/mail/domain", name="dash.mail.domain.index")
         */
        public function domainList(Request $request)
        {
            $this->getFilterId();

            $query = $this->getDoctrine()
                ->getRepository(Domain::class, 'postfix')
                ->buildQuery( $this->filterID );

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



        /**
         * @Route("/dashboard/mail/account", name="dash.mail.account.index")
         */
        public function mailboxList(Request $request)
        {
            $this->getFilterId();

            $query = $this->getDoctrine()
                ->getRepository(Mailbox::class, 'postfix')
                ->buildQuery( $this->filterID );

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('p', 1),
                10
            );


            return $this->render('dashboard/mail/account-list.html.twig', [
                'results' => $pagination
            ]);
        }



        /**
         * @Route("/dashboard/mail/forward", name="dash.mail.forward.index")
         */
        public function aliasList(Request $request)
        {
            $this->getFilterId();

            $query = $this->getDoctrine()
                ->getRepository(Alias::class, 'postfix')
                ->buildQuery( $this->filterID );

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('p', 1),
                10
            );


            return $this->render('dashboard/mail/forward-list.html.twig', [
                'results' => $pagination
            ]);
        }


        /**
         * @Route("/dashboard/mail/forward/add", name="dash.mail.forward.add")
         */
        public function aliasAdd(Request $request)
        {
            $this->getFilterId();

            // 1) build the form
            $details = new Alias();
            $form = $this->createForm(AliasForm::class, $details, ['user' => $this->filterID]);

            // 2) handle the submit (will only happen on POST)
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager('postfix');
                $entityManager->persist($details);
                $entityManager->flush();

                return $this->redirectToRoute('dash.mail.forward.index');
            }


            return $this->render('dashboard/mail/forward-edit.html.twig', [
                'item' => $details,
                'form' => $form->createView()
            ]);
        }


        /**
         * @Route("/dashboard/mail/forward/{id}/edit", name="dash.mail.forward.edit")
         */
        public function aliasEdit(Request $request, $id)
        {
            $this->getFilterId();

            $em = $this->getDoctrine()->getRepository(Alias::class, 'postfix');


            // 1) build the form
            $details = $em->findById( $id, $this->filterID );
            $form = $this->createForm(AliasForm::class, $details, ['user' => $this->filterID]);

            // 2) handle the submit (will only happen on POST)
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {



                $entityManager = $this->getDoctrine()->getManager('postfix');
                $entityManager->persist($details);
                $entityManager->flush();

                return $this->redirectToRoute('dash.mail.forward.index');
            }


            return $this->render('dashboard/mail/forward-edit.html.twig', [
                'item' => $details,
                'form' => $form->createView()
            ]);
        }



    }