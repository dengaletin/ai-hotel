<?php

declare(strict_types=1);

namespace AiHotel\Factories;

use AiHotel\Exceptions\OpenAi\OpenAiApiKeyMissingException;
use AiHotel\Providers\OpenAi\OpenAiProviderInterface;

interface ProviderFactoryInterface
{
    /**
     * @throws OpenAiApiKeyMissingException
     */
    public function createOpenAiProvider(): OpenAiProviderInterface;
}
