<?php

declare(strict_types=1);

namespace AiHotel\Enum\OpenAi;

enum Role: string
{
    case USER = 'user';
    case ASSISTANT = 'assistant';
    case SYSTEM = 'system';
}
