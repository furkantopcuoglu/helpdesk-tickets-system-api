<?php

namespace User\Presentation\Security;

use User\Domain\Entity\User;
use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\Exceptions\BadRequestException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Common\Infrastructure\MessageBus\MessengerQueryBus;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use User\Application\Commands\User\Create\CreateUserCommand;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use User\Application\RequestDto\Security\RegisterUserRequestDto;
use User\Application\Commands\User\Create\CreateUserCommandHandler;
use User\Application\Queries\User\FindByEmail\FindUserByEmailQuery;

#[Route(
    path: '/api/register',
    methods: Request::METHOD_POST,
)]
class RegisterController extends AbstractController
{
    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly MessengerQueryBus $queryBus,
    ) {
    }

    public function __invoke(
        #[MapRequestPayload] RegisterUserRequestDto $registerUserRequestDto,
    ): Payload {
        /** @var User|null $isExistUser */
        $isExistUser = $this->queryBus->handle(new FindUserByEmailQuery($registerUserRequestDto->email));

        if ($isExistUser instanceof User) {
            throw new BadRequestException('EMAIL_EXIST');
        }

        /** @var CreateUserCommandHandler $commandHandler */
        $commandHandler = $this->commandBus->handle(
            new CreateUserCommand($registerUserRequestDto->toArray()),
        );

        return $this->createPayload()
            ->setStatus(PayloadStatus::CREATED)
            ->setExtras($this->createSerializer()->normalize($commandHandler->getUser(),
                format: JsonEncoder::FORMAT,
                context: [
                    AbstractNormalizer::ATTRIBUTES => [
                        'id',
                        'name',
                        'surname',
                        'email',
                        'roles',
                        'createdAt',
                        'tokenValidAfter',
                        'updatedAt',
                    ],
                ]))
            ->setOutput($registerUserRequestDto);
    }
}
