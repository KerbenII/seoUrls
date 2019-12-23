<?php

declare(strict_types=1);

namespace App\Router;

use App\Controller\CategoryController;
use App\Controller\ProductController;
use App\Entity\UrlMapping;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Cmf\Component\Routing\ChainRouterInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;

class SeoUrlGenerator implements UrlGeneratorInterface
{
    protected $context;
    private $manager;
    private $urlGenerator;
    private $router;

    public function __construct(ChainRouterInterface $router, ManagerRegistry $managerRegistry)
    {
        $this->manager = $managerRegistry;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(RequestContext $context): void
    {
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function getContext(): RequestContext
    {
        return $this->context;
    }

    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        $getRepository = $this->manager->getRepository('App:UrlMapping');
        $urlMapping = null;
        switch (key($parameters)) {
            case 'productId':
                /** @var UrlMapping */
                $urlMapping = $getRepository->findPathForMapping(
                    ProductController::class,
                    'viewAction',
                    (int) $parameters['productId']
                );
                break;
            case 'categoryId':
                /** @var UrlMapping */
                $urlMapping = $getRepository->findPathForMapping(
                    CategoryController::class,
                    'viewAction',
                    (int) $parameters['categoryId']
                );
                break;
        }

        $context = $this->router->getContext();

        if (null === $urlMapping) {
            throw new RouteNotFoundException('SeoUrlGenerator can not find route');
        }
        $url = '';

        if (self::ABSOLUTE_PATH === $referenceType) {
            $url = $context->getScheme().'://'.$context->getHost();
        }

        return $url.$urlMapping->getPath();
    }
}
