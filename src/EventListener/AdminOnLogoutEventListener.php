<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;
use Symfony\Component\Security\Http\Event\LogoutEvent;

readonly class AdminOnLogoutEventListener implements EventSubscriberInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    public function onLogout(LogoutEvent $event): void
    {
        $token = $event->getToken();

        if ($token instanceof PostAuthenticationToken && $token->getFirewallName() !== 'admin') {
            return;
        }

        $event->setResponse(
            new RedirectResponse(
                $this->urlGenerator->generate('admin_login')
            )
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LogoutEvent::class => ['onLogout', -255],
        ];
    }
}
