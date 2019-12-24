<?php
declare(strict_types=1);

namespace App\Router;

use App\Controller\CategoryController;
use App\Controller\ProductController;
use App\Entity\UrlMapping;
use Doctrine\Common\Persistence\ManagerRegistry;
use RuntimeException;
use Symfony\Cmf\Component\Routing\ChainRouterInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;

class SeoUrlGenerator implements UrlGeneratorInterface
{
    protected $context;
    private $manager;
    private $router;

    /**
     * SeoUrlGenerator constructor.
     * @param ChainRouterInterface $router
     * @param ManagerRegistry $managerRegistry
     */
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
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH) :string
    {
        $getRepository = $this->manager->getRepository('App:UrlMapping');

        switch ($name) {
            case 'productUrl':
                $controller = ProductController::class;
                $parameterName = 'productId';
                break;
            case 'categoryUrl':
                $controller = CategoryController::class;
                $parameterName = 'categoryId';
                break;
            default:
                throw new RouteNotFoundException('SeoUrlGenerator can not generate that type of URL');
        }

        if ( !isset($parameters[$parameterName]) || !is_int($parameters[$parameterName])) {
            throw new RuntimeException("$parameterName does not exist or  is not an integer");
        }

        /** @var UrlMapping $urlMapping */
        $urlMapping = $getRepository->findPathForMapping(
            $controller,
            'viewAction',
            $parameters[$parameterName]
        );

        $context = $this->router->getContext();

        if (null === $urlMapping) {
            throw new RouteNotFoundException('SeoUrlGenerator can not find route');
        }
        $url = '';

        if (self::ABSOLUTE_PATH === $referenceType) {
            $url = sprintf('%s://%s', $context->getScheme(), $context->getHost());
        }

        return $url . $urlMapping->getPath();
    }
}
