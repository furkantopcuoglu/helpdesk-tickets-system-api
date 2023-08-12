<?php

namespace Common\Infrastructure\ChatterServices\Telegram\Strategy;

use Ticket\Domain\Entity\Ticket;
use App\Application\Enum\CategoryType;
use App\Application\Enum\PriorityType;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Message\SentMessage;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\InlineKeyboardMarkup;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\Button\InlineKeyboardButton;

class TelegramNewTicketStrategy extends AbstractTelegram implements TelegramChatterStrategyInterface
{
    public function __construct(
        #[Autowire('%env(CHATTER_TELEGRAM_ENABLED)%')]
        private readonly bool $isChatterTelegramEnabled,
        private readonly ChatterInterface $chatter,
    ) {
    }

    public function getTelegramOptions(): TelegramOptions
    {
        $ticket = $this->getTicket();

        return (new TelegramOptions())
            ->parseMode(TelegramOptions::PARSE_MODE_HTML)
            ->disableWebPagePreview(true)
            ->disableNotification(true)
            ->replyMarkup((new InlineKeyboardMarkup())
                ->inlineKeyboard([
                    (new InlineKeyboardButton('Visit New HelpDesk Ticket'))
                        ->url('https://example.com/admin/ticket/'.$ticket->getId()->toString()),
                ]),
            );
    }

    public function getTelegramMessage(): ChatMessage
    {
        $ticket = $this->getTicket();

        return new ChatMessage(
            sprintf(
                '<b>Ticket No</b> : %s '
                .PHP_EOL.
                '<b>Subject</b> : %s '
                .PHP_EOL.
                '<b>Category</b>: %s %s'
                .PHP_EOL.
                '<b>Priority</b>: %s %s'
                .PHP_EOL.
                '<b>Owner</b>: %s %s (%s)',
                $ticket->getTicketNo(),
                $ticket->getSubject(),
                $ticket->getCategory()->getName(),
                CategoryType::getEmoji($ticket->getCategory()->getColor()),
                $ticket->getPriority()->getName(),
                PriorityType::getEmoji($ticket->getPriority()->getColor()),
                $ticket->getOwner()->getName(),
                $ticket->getOwner()->getSurname(),
                $ticket->getOwner()->getEmail(),
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
