<?php

declare(strict_types=1);

namespace AiHotel\Services;

use AiHotel\Factories\ProviderFactory;
use AiHotel\Factories\ProviderFactoryInterface;
use AiHotel\Providers\OpenAi\OpenAiProviderInterface;

class AiHotelClient implements AiHotelClientInterface
{
    private ProviderFactoryInterface $factory;

    public function __construct(?ProviderFactoryInterface $factory = null)
    {
        $this->factory = $factory ?? new ProviderFactory();
    }

    public function gpt(): OpenAiProviderInterface
    {
        return $this->factory->createOpenAiProvider();
    }

    public static function create(array $config): self
    {
        $factory = new ProviderFactory(
            openAiApiKey: $config['openai_api_key'] ?? null
        );
        
        return new self($factory);
    }
}
