<?php

namespace Common\Application\Utils;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidatorMessageFormatter
{
    public static function format(ConstraintViolationListInterface $violationList): array
    {
        $messages = [];

        /** @var ConstraintViolationInterface $violation */
        foreach ($violationList as $violation) {
            if (empty($violation->getPropertyPath()) && isset($violation->getParameters()['hint'])) {
                $hintMessage = $violation->getParameters()['hint'];
                preg_match('/"(.*?)"/', $hintMessage, $field);
                $messages[$field[1]][] = $hintMessage;

                return $messages;
            }
            $field = str_replace(['[', ']'], '', $violation->getPropertyPath());
            $messages[$field][] = $violation->getMessage();
        }

        return $messages;
    }
}
