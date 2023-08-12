<?php

namespace Common\Infrastructure\ChatterServices\Telegram\Strategy;

use Ticket\Domain\Entity\Ticket;
use Common\Application\Enum\TelegramChatterType;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Message\SentMessage;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;

class TelegramAssigmentSupportTicketStrategy extends AbstractTelegram implements TelegramChatterStrategyInterface
{
    public function __construct(
        #[Autowire('%env(CHATTER_TELEGRAM_ENABLED)%')]
        private readonly bool $isChatterTelegramEnabled,
        private readonly ChatterInterface $chatter,
    ) {
    }

    public function getTelegramOptions(): TelegramOptions
    {
        return (new TelegramOptions())
            ->parseMode(TelegramOptions::PARSE_MODE_HTML)
            ->disableWebPagePreview(true)
            ->disableNotification(true);
    }

    public function getTelegramMessage(): ChatMessage
    {
        $ticket = $this->getTicket();

        return new ChatMessage(
            sprintf(
                '<b>Ticket No</b> : %s '
                .PHP_EOL.
                '<b>Assigment Support:</b> %s'
                .PHP_EOL.
                '<b>Action:</b> %s',
                $ticket->getTicketNo(),
                $ticket->getSupport()->getEmail(),
                TelegramChatterType::ASSIGMENT_SUPPORT_TICKET->value,
            ),
        );
    }

    public function sendMessage(Ticket $ticket): ?SentMessage
    {
        if (!$this->isChatterTelegramEnabled) {
            return null;
        }

        $this->setTicket($ticket);

        $chatMessage = $this->getTelegramMessage();

        $telegramOptions = $this->getTelegramOptions();

        $chatMessage->options($telegramOptions);

        return $this->chatter->send($chatMessage);
    }
}
