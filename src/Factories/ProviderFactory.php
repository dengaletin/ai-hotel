<?php

declare(strict_types=1);

namespace AiHotel\Factories;

use AiHotel\Providers\OpenAi\OpenAiProvider;
use AiHotel\Providers\OpenAi\OpenAiProviderInterface;

class ProviderFactory implements ProviderFactoryInterface
{
    public function createOpenAiProvider(): OpenAiProviderInterface
    {
        $apiKey = getenv('OPENAI_API_KEY') ?: $_ENV['OPENAI_API_KEY'] ?? '';

        return new OpenAiProvider($apiKey);
    }
}
