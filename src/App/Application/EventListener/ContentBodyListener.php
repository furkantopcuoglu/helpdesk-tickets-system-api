<?php

namespace App\Application\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ContentBodyListener
{
    public function onKernelRequest(KernelEvent $event): bool
    {
        $request = $event->getRequest();
        $method = $request->getMethod();

        if (\count($request->request->all())) {
            return false;
        }

        if (!\in_array(
            $method,
            [
                Request::METHOD_POST,
                Request::METHOD_PUT,
                Request::METHOD_PATCH,
                Request::METHOD_DELETE,
                Request::METHOD_OPTIONS,
            ],
            true,
        )) {
            return false;
        }

        $content = $request->getContent();

        if (empty($content)) {
            return false;
        }

        $data = json_decode($content, true);

        if (\is_array($data)) {
            $request->request->replace($data);
        } else {
            throw new BadRequestHttpException('Invalid JSON request');
        }

        return true;
    }
}
