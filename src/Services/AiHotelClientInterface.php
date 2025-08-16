<?php

declare(strict_types=1);

namespace AiHotel\Services;

use AiHotel\Exceptions\OpenAi\OpenAiApiKeyMissingException;
use AiHotel\Providers\OpenAi\OpenAiProviderInterface;

interface AiHotelClientInterface
{
    /**
     * @throws OpenAiApiKeyMissingException
     */
    public function gpt(): OpenAiProviderInterface;
}
