<?php

namespace Common\Application\Utils;

/**
 * @method $this setExtras($extras)
 * @method $this setStatus($status)
 * @method $this setOutput($output)
 * @method $this setMessages($messages)
 */
class Payload extends \Aura\Payload\Payload
{
    public function addMessage(string $message): static
    {
        $messages = $this->getMessages() ?: [];

        $this->setMessages([
            ...$messages,
            $message,
        ]);

        return $this;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->getStatus(),
            'input' => $this->getInput(),
            'output' => $this->getOutput(),
            'messages' => $this->getMessages(),
            'extras' => $this->getExtras(),
        ];
    }
}
