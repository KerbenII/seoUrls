<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Categories extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $categoriesData = [
            Category::SHOES,
            Category::JACKETS,
        ];

        foreach ($categoriesData as $categoryName) {
            $product = new Category();
            $product->setName($categoryName);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
