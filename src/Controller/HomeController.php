<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\UrlMapping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $mappingToChange = new UrlMapping();
        $mappingToChange->setPath('/musztardowa-kurteczka');
        $mappingToChange->setMethod('viewAction');
        $mappingToChange->setController(ProductController::class);
        $mappingToChange->setIdentifier(6);
        $result = $entityManager->getRepository('App:UrlMapping')
            ->createOrUpdateAndRedirect($mappingToChange);
        dump($result);
        die;
        $categories = $this->getDoctrine()
            ->getRepository('App:Category')
            ->findAll();

        return  $this->render('home.html.twig', [
            'categories' => $categories,
        ]);
    }
}
