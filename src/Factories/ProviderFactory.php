<?php

declare(strict_types=1);

namespace AiHotel\Factories;

use AiHotel\Exceptions\OpenAi\OpenAiApiKeyMissingException;
use AiHotel\Providers\OpenAi\OpenAiProvider;
use AiHotel\Providers\OpenAi\OpenAiProviderInterface;

readonly class ProviderFactory implements ProviderFactoryInterface
{
    public function __construct(
        private ?string $openAiApiKey = null
    ) {
    }

    public function createOpenAiProvider(): OpenAiProviderInterface
    {
        if (empty($this->openAiApiKey)) {
            throw new OpenAiApiKeyMissingException();
        }

        return new OpenAiProvider($this->openAiApiKey);
    }
}
