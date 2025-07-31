<?php

declare(strict_types=1);

namespace AiHotel\Services\Builders\OpenAi;

use AiHotel\Dto\Request\OpenAi\History;
use AiHotel\Enum\OpenAi\Role;

interface HistoryBuilderInterface
{
    public function addMessage(Role $role, string $content): self;

    public function clear(): self;

    public function getMessages(): array;

    public function build(): History;
}
