<?php

declare(strict_types=1);

namespace AiHotel\Factories;

use AiHotel\Providers\OpenAi\OpenAiProvider;
use AiHotel\Providers\OpenAi\OpenAiProviderInterface;

class ProviderFactory
{
    public function createOpenAiProvider(): OpenAiProviderInterface
    {
        $apiKey = $_ENV['OPENAI_API_KEY'] ?? getenv('OPENAI_API_KEY') ?: '';

        return new OpenAiProvider($apiKey);
    }
}
