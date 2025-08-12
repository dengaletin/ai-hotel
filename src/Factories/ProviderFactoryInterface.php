<?php

declare(strict_types=1);

namespace AiHotel\Factories;

use AiHotel\Providers\OpenAi\OpenAiProviderInterface;

interface ProviderFactoryInterface
{
    public function createOpenAiProvider(): OpenAiProviderInterface;
}
