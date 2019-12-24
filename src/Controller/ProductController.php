<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    /**
     * @param $id int product identifier
     * @return Response
     */
    public function viewAction($id): Response
    {
        $product = $this->getDoctrine()
            ->getRepository('App:Product')
            ->findOneById($id);

        return  $this->render('product.html.twig', [
            'product' => $product,
        ]);
    }
}
