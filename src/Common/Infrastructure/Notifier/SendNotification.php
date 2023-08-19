<?php

namespace Common\Infrastructure\Notifier;

use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\RecipientInterface;

readonly class SendNotification implements NotifierInterface
{
    public function __construct(
        private NotifierInterface $notifier,
    ) {
    }

    public function send(Notification $notification, RecipientInterface ...$recipients): void
    {
        foreach ($recipients as $recipient) {
            $this->notifier->send($notification, $recipient);
        }
    }
}
