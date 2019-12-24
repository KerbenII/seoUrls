<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    /**
     * @param $id int category identifier
     * @return Response
     */
    public function viewAction($id): Response
    {
        /** @var Category $category */
        $category = $this->getDoctrine()
            ->getRepository('App:Category')
            ->findOneById($id);

        return  $this->render('category.html.twig', [
            'category' => $category,
            'products' => $category->getProduct(),
        ]);
    }
}
