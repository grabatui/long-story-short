<?php

namespace App\EventListener;

use App\Core\Persistence\Entity\User;
use Sentry\State\Scope;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

use function Sentry\configureScope;

readonly class RequestListener implements EventSubscriberInterface
{
    public function __construct(
        private Security $security
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::REQUEST => 'onKernelRequest'];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        /** @var User|null $user */
        $user = $this->security->getUser();

        if (!$user) {
            return;
        }

        configureScope(
            fn (Scope $scope) => $scope->setUser([
                'id' => $user->getId(),
                'email' => $user->getEmail(),
            ])
        );
    }
}
