<?php
declare(strict_types=1);

namespace App\Router;

use App\Controller\CategoryController;
use App\Controller\ProductController;
use App\Entity\UrlMapping;
use App\Repository\UrlMappingRepository;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\DoctrineProvider;
use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteProvider extends DoctrineProvider implements RouteProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRouteCollectionForRequest(Request $request): RouteCollection
    {
        $routeCollection = new RouteCollection();
        $requestPath = $request->getPathInfo();

        $urlMapping = $this->getRouteRepository()->findUrlMappingsByPath($requestPath);

        if (null === $urlMapping) {
            return $routeCollection;
        }

        $route = $this->createRouteUsingUrlMapping($urlMapping[0]);
        $routeCollection->add($requestPath, $route);

        return $routeCollection;
    }

    /**
     * @param UrlMapping $urlMapping
     * @return Route
     */
    private function createRouteUsingUrlMapping(UrlMapping $urlMapping): Route
    {
        $routeArray = [
            '_controller' => [
                $urlMapping->getController(),
                $urlMapping->getMethod()
            ],
            'id' => $urlMapping->getIdentifier()
        ];

        return new Route(
            $urlMapping->getPath(),
            $routeArray,
            [],
            ['utf8' => true]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteByName($name): Route
    {
        $urlMapping = $this->getRouteRepository()->findUrlMappingsByPath($name);
        if (null === $urlMapping) {
            throw new RouteNotFoundException("Route not found for $name");
        }

        return $this->createRouteUsingUrlMapping($urlMapping[0]);
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutesByNames($names): ?array
    {
        $routes = [];
        $urlMappings = $this->getRouteRepository()->findUrlMappingsByPath($names);
        foreach ($urlMappings as $urlMapping) {
            $routes[] = $this->createRouteUsingUrlMapping($urlMapping);
        }
        return $routes;
    }

    /**
     * @return UrlMappingRepository
     */
    private function getRouteRepository()
    {
        return $this->getObjectManager()->getRepository('App:UrlMapping');
    }
}
