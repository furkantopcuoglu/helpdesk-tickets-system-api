<?php

namespace Common\Infrastructure\Notifier\Email;

use User\Domain\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\EmailRecipientInterface;
use Symfony\Component\Notifier\Notification\EmailNotificationInterface;

class CustomEmailNotification extends Notification implements EmailNotificationInterface
{
    public function __construct(
        private readonly User $user,
        private readonly string $subject,
        private readonly array $channels,
    ) {
        parent::__construct($this->subject, $this->channels);
    }

    public function asEmailMessage(EmailRecipientInterface $recipient, string $transport = null): ?EmailMessage
    {
        $this->importance('');

        $emailMessage = EmailMessage::fromNotification($this, $recipient);

        /** @var TemplatedEmail $templatedEmail */
        $templatedEmail = $emailMessage->getMessage();
        $templatedEmail
            ->htmlTemplate('custom-email.html.twig')
            ->context([
                'user' => $this->user,
                'content' => $this->getContent(),
                'sendEmail' => $recipient->getEmail(),
            ]);

        return $emailMessage;
    }
}
