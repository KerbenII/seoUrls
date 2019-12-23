<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\UrlMapping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function indexAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('App:Category')
            ->findAll();

        return  $this->render('home.html.twig', [
            'categories' => $categories,
        ]);
    }
}
