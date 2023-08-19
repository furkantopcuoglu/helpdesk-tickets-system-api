<?php

namespace App\Presentation\Admin\Priority;

use App\Domain\Entity\Priority;
use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\ParamConverts\PriorityConverter;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route(
    path: '/api/admin/priority/{priority}',
    requirements: [
        'priority' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_GET,
)]
#[ParamConverter('priority', class: PriorityConverter::class)]
class DetailController extends AbstractController
{
    public function __invoke(Priority $priority): Payload
    {
        return $this->createPayload()
            ->setStatus(PayloadStatus::SUCCESS)
            ->setExtras($this->createSerializer()->normalize($priority));
    }
}
