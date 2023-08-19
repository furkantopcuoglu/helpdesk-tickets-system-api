<?php

namespace Common\Application\MessageHandler\Email\Send;

use Common\Domain\Message\SendEmailQueueMessage;
use Symfony\Component\Notifier\Recipient\Recipient;
use Common\Infrastructure\Notifier\SendNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Common\Infrastructure\Notifier\Email\CustomEmailNotification;

#[AsMessageHandler]
readonly class SendEmailQueueMessageHandler
{
    public function __construct(
        private SendNotification $sendNotification,
    ) {
    }

    public function __invoke(SendEmailQueueMessage $message): void
    {
        $customEmail = (new CustomEmailNotification(
            user: $message->user,
            subject: $message->subject,
            channels: ['email'],
        ))->content($message->content);

        $recipient = new Recipient($message->to);

        $this->sendNotification->send($customEmail, $recipient);
    }
}
