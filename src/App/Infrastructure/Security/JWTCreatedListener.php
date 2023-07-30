<?php

namespace App\Infrastructure\Security;

use User\Domain\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

readonly class JWTCreatedListener
{
    public function __invoke(JWTCreatedEvent $event): void
    {
        /** @var User|null $user */
        $user = $event->getUser();
        $payload = $event->getData();

        $payloadData = $this->getPayloadData($user);

        if (!($payloadData['user'] instanceof User)) {
            throw new AccessDeniedHttpException();
        }

        $payload['roles'] = $payloadData['user']->getRoles();

        $event->setData($payload);
    }

    private function getPayloadData(?User $user): array
    {
        if ($user instanceof User) {
            return [
                'user' => $user,
            ];
        }

        return [];
    }
}
