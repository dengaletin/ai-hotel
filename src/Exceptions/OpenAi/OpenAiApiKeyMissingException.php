<?php

declare(strict_types=1);

namespace AiHotel\Exceptions\OpenAi;

use AiHotel\Enum\Providers;
use AiHotel\Exceptions\ProviderException;

class OpenAiApiKeyMissingException extends ProviderException
{
    public function __construct()
    {
        parent::__construct(
            Providers::OPENAI->value,
            Providers::OPENAI->value . ' API key is required for chat requests'
        );
    }
}
