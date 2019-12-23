<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    /**
     * @param $productId
     * @return Response
     */
    public function viewAction($productId): Response
    {
        $product = $this->getDoctrine()
            ->getRepository('App:Product')
            ->findOneById($productId);

        return  $this->render('product.html.twig', [
            'product' => $product,
        ]);
    }
}
