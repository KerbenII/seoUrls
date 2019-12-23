<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Products extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /** @var CategoryRepository $categories */
        $categories = $manager->getRepository('App:Category');

        $jackets = $categories->findByName(Category::JACKETS);
        $shoes = $categories->findByName(Category::SHOES);
        $productsData = [
            'Czarna Ramoneska Winter Fear' => [109.99, $jackets],
            'Czarne Śniegowce Kenthurst' => [109.99, $shoes],
            'Białe Śniegowce Kenthurst' => [49.99, $shoes],
            'Biała Kurtka Gravataí' => [219.99, $jackets],
            'Zielona Kurtka Gravataí' => [219.99, $jackets],
            'Musztardowa Kurtka Gravataí' => [109.99, $jackets],
        ];

        foreach ($productsData as $productName => $productAttributes) {
            $product = new Product();
            $product->setName($productName);
            $product->setPrice($productAttributes[0]);
            $product->setCategory($productAttributes[1]);
            $manager->persist($product);
        }
        $manager->flush();
    }
}
