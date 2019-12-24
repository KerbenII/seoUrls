<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @return Response
     */
    public function indexAction(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository('App:Category')
            ->findAll();

        return  $this->render('home.html.twig', [
            'categories' => $categories,
        ]);
    }
}
