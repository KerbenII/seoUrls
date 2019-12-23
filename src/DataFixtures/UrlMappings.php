<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Controller\CategoryController;
use App\Controller\ProductController;
use App\Entity\UrlMapping;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UrlMappings extends Fixture
{
    const PRODUCT_CONTROLLER = ProductController::class;
    const CATEGORY_CONTROLLER = CategoryController::class;

    public function load(ObjectManager $manager)
    {
        $urlMappingsFixtures = [
            [
                'path' => '/czarna-ramoneska-winter-fear',
                'controller' => self::PRODUCT_CONTROLLER,
                'method' => 'viewAction',
                'identifier' => 1,
            ],
            [
                'path' => '/czarne-sniegowce-kenthurst',
                'controller' => self::PRODUCT_CONTROLLER,
                'method' => 'viewAction',
                'identifier' => 2,
            ],
            [
                'path' => '/biale-sniegowce-kenthurst',
                'controller' => self::PRODUCT_CONTROLLER,
                'method' => 'viewAction',
                'identifier' => 3,
            ],
            [
                'path' => '/biala-kurtka-gravatai',
                'controller' => self::PRODUCT_CONTROLLER,
                'method' => 'viewAction',
                'identifier' => 4,
            ],
            [
                'path' => '/zielona-kurtka-gravatai',
                'controller' => self::PRODUCT_CONTROLLER,
                'method' => 'viewAction',
                'identifier' => 5,
            ],
            [
                'path' => '/musztardowa-kurtka-gravatai',
                'controller' => self::PRODUCT_CONTROLLER,
                'method' => 'viewAction',
                'identifier' => 6,
            ],
            [
                'path' => '/buty',
                'controller' => self::CATEGORY_CONTROLLER,
                'method' => 'viewAction',
                'identifier' => 1,
            ],
            [
                'path' => '/kurtka',
                'controller' => self::CATEGORY_CONTROLLER,
                'method' => 'viewAction',
                'identifier' => 2,
            ],
        ];

        foreach ($urlMappingsFixtures as $urlMappingFixture) {
            $urlMapping = new UrlMapping();
            $urlMapping->setPath($urlMappingFixture['path']);
            $urlMapping->setController($urlMappingFixture['controller']);
            $urlMapping->setMethod($urlMappingFixture['method']);
            $urlMapping->setIdentifier($urlMappingFixture['identifier']);
            $manager->persist($urlMapping);
        }

        $manager->flush();
    }
}
