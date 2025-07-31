<?php

declare(strict_types=1);

namespace AiHotel\Dto\Request\OpenAi;

class History
{
    private array $messages;

    public function __construct(array $messages = [])
    {
        $this->messages = $messages;
    }

    public function toArray(): array
    {
        return $this->messages;
    }
}
