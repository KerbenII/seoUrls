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

    const PATH = 'path';
    const CONTROLLER ='controller';
    const METHOD = 'viwAction';
    const IDENTIFIER = 'identifier';
    const PRODUCT_CLASS = ProductController::class;
    const CATEGORY_CLASS = CategoryController::class;
    const VIEW_ACTION ='viewAction';
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $urlMappingsFixtures = [
            [
                self::PATH => '/czarna-ramoneska-winter-fear',
                self::CONTROLLER => self::PRODUCT_CLASS,
                self::IDENTIFIER => 1,
            ],
            [
                self::PATH => '/czarne-sniegowce-kenthurst',
                self::CONTROLLER => self::PRODUCT_CLASS,
                self::IDENTIFIER => 2,
            ],
            [
                self::PATH => '/biale-sniegowce-kenthurst',
                self::CONTROLLER => self::PRODUCT_CLASS,
                self::IDENTIFIER => 3,
            ],
            [
                self::PATH => '/biala-kurtka-gravatai',
                self:: CONTROLLER => self::PRODUCT_CLASS,
                self::IDENTIFIER => 4,
            ],
            [
                self::PATH => '/zielona-kurtka-gravatai',
                self::CONTROLLER => self::PRODUCT_CLASS,
                self::IDENTIFIER => 5,
            ],
            [
                self::PATH => '/musztardowa-kurtka-gravatai',
                self::CONTROLLER => self::PRODUCT_CLASS,
                self::IDENTIFIER => 6,
            ],
            [
                self::PATH => '/buty',
                self::CONTROLLER => self::CATEGORY_CLASS,
                self::IDENTIFIER => 1,
            ],
            [
                self::PATH => '/kurtka',
                self::CONTROLLER => self::CATEGORY_CLASS,
                self::IDENTIFIER => 2,
            ],
        ];

        foreach ($urlMappingsFixtures as $urlMappingFixture) {
            $urlMapping = new UrlMapping();
            $urlMapping->setPath($urlMappingFixture['path']);
            $urlMapping->setController($urlMappingFixture['controller']);
            $urlMapping->setMethod(self::VIEW_ACTION);
            $urlMapping->setIdentifier($urlMappingFixture['identifier']);
            $manager->persist($urlMapping);
        }

        $manager->flush();
    }
}
