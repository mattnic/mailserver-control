<?php
    namespace App\Controller;

    use App\Entity\Postfix\Domain;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class MailController extends AbstractController
    {
        /**
         * @Route("/dashboard/mail", name="dash.mail.index")
         */
        public function index()
        {

            $results = $this->getDoctrine()
                ->getRepository(Domain::class, 'postfix')
                ->findAll();


            return $this->render('dashboard/mail/index.html.twig', [
                'results' => $results
            ]);
        }
    }