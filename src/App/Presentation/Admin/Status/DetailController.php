<?php

namespace App\Presentation\Admin\Status;

use App\Domain\Entity\Status;
use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use App\Domain\ParamConverts\StatusConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route(
    path: '/api/admin/status/{status}',
    requirements: [
        'status' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_GET,
)]
#[ParamConverter('status', class: StatusConverter::class)]
class DetailController extends AbstractController
{
    public function __invoke(Status $status): Payload
    {
        return $this->createPayload()
            ->setStatus(PayloadStatus::SUCCESS)
            ->setExtras($this->createSerializer()->normalize($status));
    }
}
