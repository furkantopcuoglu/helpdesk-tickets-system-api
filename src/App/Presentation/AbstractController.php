<?php

namespace App\Presentation;

use User\Domain\Entity\User;
use Common\Application\Utils\Payload;
use GBProd\UuidNormalizer\UuidNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as BaseController;

/**
 * @method User getUser()
 */
abstract class AbstractController extends BaseController
{
    public function createPayload(): Payload
    {
        return new Payload();
    }

    protected function getUserId(): ?string
    {
        $user = $this->getUser();

        if (!($user instanceof UserInterface)) {
            return null;
        }

        return $user->getId()->toString();
    }

    protected function createSerializer(): Serializer
    {
        $encoder = new JsonEncoder();
        $dateTimeNormalizerContext = [
            DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i:s',
        ];

        $objectNormalizerContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object) {
                return $object->getId();
            },
        ];

        $objectNormalizer = new ObjectNormalizer(defaultContext: $objectNormalizerContext);

        return new Serializer([new UuidNormalizer(), new DateTimeNormalizer($dateTimeNormalizerContext), $objectNormalizer], [$encoder]);
    }
}
