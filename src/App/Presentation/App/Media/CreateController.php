<?php

namespace App\Presentation\App\Media;

use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Common\Application\Enum\MediaModuleType;
use Common\Application\Enum\StoragePathType;
use Symfony\Component\HttpFoundation\Request;
use Common\Application\Traits\RandomUniqTrait;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Common\Infrastructure\StorageService\StorageOptions;
use Common\Infrastructure\MessageBus\MessengerCommandBus;
use App\Application\RequestDto\Media\CreateMediaRequestDto;
use Common\Infrastructure\StorageService\LocalStorageService;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Common\Application\Commands\Media\Create\CreateMediaCommand;

#[Route(
    path: '/api/media',
    methods: Request::METHOD_POST,
)]
class CreateController extends AbstractController
{
    use RandomUniqTrait;

    public function __construct(
        private readonly MessengerCommandBus $commandBus,
        private readonly LocalStorageService $storageService,
    ) {
    }

    public function __invoke(
        #[MapRequestPayload] CreateMediaRequestDto $dto,
    ): Payload {
        $storageResponse = $this->storageService->uploadWithBase64(new StorageOptions([
            'user' => $this->getUser(),
            'file' => $dto->file,
            'path' => StoragePathType::UPLOADS->value,
        ]));

        $media = $this->commandBus->handle(new CreateMediaCommand([
            'name' => $storageResponse->fileName,
            'path' => $storageResponse->path,
            'url' => $storageResponse->url,
            'user' => $this->getUser(),
            'module' => MediaModuleType::LOCAL_TICKET_FILE->value,
        ]));

        return $this->createPayload()
            ->setStatus(PayloadStatus::CREATED)
            ->setExtras($this->createSerializer()->normalize(
                $media,
                format: JsonEncoder::FORMAT,
                context: [
                    AbstractNormalizer::ATTRIBUTES => [
                        'id',
                    ],
                ]),
            );
    }
}
