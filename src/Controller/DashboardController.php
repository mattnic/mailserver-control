<?php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;

    class DashboardController extends AbstractController
    {
        /**
         * @Route("/", name="dash.root")
         */
        public function root()
        {

            return $this->redirectToRoute('dash.index');
        }



        /**
         * @Route("/dashboard", name="dash.index")
         */
        public function index()
        {

            return $this->render('dashboard/index.html.twig', [
                'number' => ''
            ]);
        }
    }