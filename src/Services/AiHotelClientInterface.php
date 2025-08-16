<?php

declare(strict_types=1);

namespace AiHotel\Services;

use AiHotel\Providers\OpenAi\OpenAiProviderInterface;

interface AiHotelClientInterface
{
    public function gpt(): OpenAiProviderInterface;

    public static function create(array $config): self;
}
