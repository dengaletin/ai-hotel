<?php

declare(strict_types=1);

namespace AiHotel\Services;

use AiHotel\Factories\ProviderFactory;
use AiHotel\Providers\OpenAi\OpenAiProviderInterface;
use Dotenv\Dotenv;

class AiHotelClient
{
    private ProviderFactory $factory;

    public function __construct()
    {
        $this->loadDotEnv();
        $this->factory = new ProviderFactory();
    }

    public function gpt(): OpenAiProviderInterface
    {
        return $this->factory->createOpenAiProvider();
    }

    private function loadDotEnv(): void
    {
        if (!class_exists(Dotenv::class)) {
            return;
        }

        $projectRoot = getcwd();
        $envFile = $projectRoot . '/.aihotel.env';

        if (file_exists($envFile)) {
            $dotenv = Dotenv::createImmutable($projectRoot, '.aihotel.env');
            $dotenv->safeLoad();
        }
    }
}
