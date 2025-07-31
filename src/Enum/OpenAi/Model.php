<?php

declare(strict_types=1);

namespace AiHotel\Enum\OpenAi;

enum Model: string
{
    case GPT_4 = 'gpt-4';
    case GPT_4_TURBO = 'gpt-4-turbo';
    case GPT_3_5_TURBO = 'gpt-3.5-turbo';
}
