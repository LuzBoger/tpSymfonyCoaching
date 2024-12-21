<?php
namespace App\EventListener;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;

class CheckBannedUserKernelSubscriber implements EventSubscriberInterface
{
    private Security $security;
    private RouterInterface $router;

    public function __construct(Security $security, RouterInterface $router)
    {
        $this->security = $security;
        $this->router = $router;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // Exclure la route "banned_page" pour éviter une boucle infinie
        if ($request->attributes->get('_route') === 'banned_page') {
            return;
        }

        $user = $this->security->getUser();

        if ($user && in_array('ROLE_BANNED', $user->getRoles())) {
            $response = new RedirectResponse($this->router->generate('banned_page'));
            $event->setResponse($response);
        }
    }
}
