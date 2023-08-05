<?php

namespace Common\Infrastructure\ChatterService\Telegram\Ticket\New;

use Ticket\Domain\Entity\Ticket;
use App\Application\Enum\CategoryType;
use App\Application\Enum\PriorityType;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\InlineKeyboardMarkup;
use Symfony\Component\Notifier\Bridge\Telegram\Reply\Markup\Button\InlineKeyboardButton;

readonly class ChatterTelegramNewTicket
{
    public function __construct(
        private ChatterInterface $chatter,
    ) {
    }

    public function handle(Ticket $ticket): void
    {
        $text = sprintf(
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
        );

        $chatMessage = new ChatMessage($text);

        // Create Telegram options
        $telegramOptions = (new TelegramOptions())
            ->parseMode(TelegramOptions::PARSE_MODE_HTML)
            ->disableWebPagePreview(true)
            ->disableNotification(true)
            ->replyMarkup((new InlineKeyboardMarkup())
                ->inlineKeyboard([
                    (new InlineKeyboardButton('Visit New HelpDesk Ticket'))
                        ->url('https://example.com/admin/ticket/'.$ticket->getId()->toString()),
                ]),
            );

        $chatMessage->options($telegramOptions);

        $this->chatter->send($chatMessage);
    }
}
