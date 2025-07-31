<?php

declare(strict_types=1);

namespace AiHotel\Services\Builders\OpenAi;

use AiHotel\Dto\Request\OpenAi\History;
use AiHotel\Enum\OpenAi\Role;

class HistoryBuilder implements HistoryBuilderInterface
{
    private array $messagesData = [];

    public function addMessage(Role $role, string $content): self
    {
        $this->messagesData[] = [
            'role' => $role->value,
            'content' => $content
        ];

        return $this;
    }

    public function clear(): self
    {
        $this->messagesData = [];

        return $this;
    }

    public function getMessages(): array
    {
        return $this->messagesData;
    }

    public function build(): History
    {
        return new History($this->messagesData);
    }
}
