<?php

namespace App\Presentation\Admin\Category;

use App\Domain\Entity\Category;
use Common\Application\Utils\Payload;
use App\Presentation\AbstractController;
use Aura\Payload_Interface\PayloadStatus;
use Symfony\Component\HttpFoundation\Request;
use App\Domain\ParamConverts\CategoryConverter;
use Symfony\Component\Routing\Annotation\Route;
use Common\Application\Utils\RouteRequirementUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route(
    path: '/api/admin/category/{category}',
    requirements: [
        'category' => RouteRequirementUtil::uuid,
    ],
    methods: Request::METHOD_GET,
)]
#[ParamConverter('category', class: CategoryConverter::class)]
class DetailController extends AbstractController
{
    public function __invoke(Category $category): Payload
    {
        return $this->createPayload()
            ->setStatus(PayloadStatus::SUCCESS)
            ->setExtras($this->createSerializer()->normalize($category));
    }
}
