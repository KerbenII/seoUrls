<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Redirection;
use App\Repository\RedirectionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RedirectionListener
{
    private $registry;

    /**
     * RedirectionListener constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function onKernelRequest(RequestEvent $event): ?Response
    {
        $route = $event->getRequest()->attributes->get('_route');
        if (null !== $route) {
            return null;
        }
        /** @var \Exception $exception */
        $exception = $event->getRequest()->attributes->get('exception');
        if (null === $exception || !$exception instanceof NotFoundHttpException) {
            return null;
        }

        /** @var RedirectionRepository $RedirectionRepository */
        $redirectionRepository = $this->registry->getManager()->getRepository('App:Redirection');

        /** @var Redirection $redirection */
        $redirection = $redirectionRepository->findRedirectionByPath($event->getRequest()->getPathInfo());

        if (null === $redirection) {
            return null;
        }

        return $event->setResponse(new RedirectResponse($redirection->getToPath(), $redirection->getStatusCode()));
    }
}
