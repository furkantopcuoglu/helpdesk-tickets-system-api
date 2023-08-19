<?php

namespace Ticket\Presentation\App\Ticket;

use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use App\Domain\Exceptions\NotFoundException;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;
use App\Domain\Exceptions\FailedOperationException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Application\Queries\Media\Find\FindMediaQuery;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\Queries\Category\Find\FindCategoryQuery;
use App\Application\Queries\Priority\Find\FindPriorityQuery;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Ticket\Application\RequestDto\Ticket\CreateTicketRequestDto;
use Ticket\Application\Commands\Ticket\Create\CreateTicketCommand;
use Ticket\Application\Commands\Ticket\Create\CreateTicketCommandHandler;

#[Route(
    path: '/api/ticket',
    methods: Request::METHOD_POST,
)]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    public function __invoke(
        #[MapRequestPayload] CreateTicketRequestDto $dto,
    ): Payload {
        $options = $this->createOptionsResolver($dto->toArray());

        /** @var CreateTicketCommandHandler $createTicketCommandHandler */
        $createTicketCommandHandler = $this->commandBus->handle(
            new CreateTicketCommand([
                'subject' => $options['subject'],
                'content' => $options['content'],
                'priority' => $options['priorityId'],
                'category' => $options['categoryId'],
                'owner' => $this->getUser(),
                'files' => $options['files'],
            ]));

        $ticket = $createTicketCommandHandler->getTicket();

        if (!$ticket) {
            throw new FailedOperationException('FAILED');
        }

        // Trigger Create Ticket Event
        $createTicketCommandHandler->triggerEvent();

        return $this->createPayload()
            ->setStatus(PayloadStatus::CREATED)
            ->setExtras($this->createSerializer()->normalize($ticket,
                format: JsonEncoder::FORMAT,
                context: [
                    AbstractNormalizer::ATTRIBUTES => [
                        'id',
                    ],
                ]))
            ->setOutput($dto->toArray());
    }

    private function createOptionsResolver(array $options): array
    {
        $optionsResolver = new OptionsResolver();

        $optionsResolver->setRequired([
            'subject',
            'content',
            'priorityId',
            'categoryId',
        ]);

        $optionsResolver->setDefined([
            'files',
        ]);

        $optionsResolver->setNormalizer('priorityId', function ($options, $value) {
            $priority = $this->queryBus->handle(new FindPriorityQuery($value));

            if (!$priority) {
                throw new NotFoundException('NOT_FOUND_PRIORITY');
            }

            return $priority;
        });

        $optionsResolver->setNormalizer('categoryId', function ($options, $value) {
            $category = $this->queryBus->handle(new FindCategoryQuery($value));

            if (!$category) {
                throw new NotFoundException('NOT_FOUND_CATEGORY');
            }

            return $category;
        });

        $optionsResolver->setNormalizer('files', function ($options, $value) {
            if (!isset($value)) {
                return null;
            }

            return collect($value)->map(function ($file) {
                $file = $this->queryBus->handle(new FindMediaQuery($file));

                if (!$file) {
                    throw new BadRequestException('NOT_FOUND_FILE');
                }

                return $file;
            })->toArray();
        });

        return $optionsResolver->resolve($options);
    }
}
