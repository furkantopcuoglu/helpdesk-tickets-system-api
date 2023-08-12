<?php

namespace Support\Presentation\App\Ticket\Search;

use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\PaginationResponse;
use Support\Application\QueryDto\SearchTicketQueryDto;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Ticket\Application\Queries\Ticket\Search\SearchTicketQuery;

#[Route(
    path: '/api/support/tickets',
    methods: Request::METHOD_GET,
)]
class SearchTicketAssigmentController extends AbstractController
{
    public function __construct(
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    public function __invoke(
        #[MapQueryString] ?SearchTicketQueryDto $queryDto,
    ): Payload {
        /** @var PaginationResponse $paginationResponse */
        $paginationResponse = $this->queryBus->handle(
            new SearchTicketQuery([...($queryDto?->toArray() ?? []), ...[
                'isAssigment' => false,
            ]]),
        );

        return $this->createPayload()
            ->setStatus(PayloadStatus::SUCCESS)
            ->setExtras($paginationResponse->toArray())
            ->setOutput($queryDto?->toArray());
    }
}
