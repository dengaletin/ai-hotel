<?php

declare(strict_types=1);

namespace AiHotel\Services;

use AiHotel\Factories\ProviderFactory;
use AiHotel\Factories\ProviderFactoryInterface;
use AiHotel\Providers\OpenAi\OpenAiProviderInterface;

class AiHotelClient implements AiHotelClientInterface
{
    private static bool $envLoaded = false;
    private ProviderFactoryInterface $factory;

    public function __construct(?ProviderFactoryInterface $factory = null)
    {
        self::loadEnvironment();
        $this->factory = $factory ?? new ProviderFactory();
    }

    public function gpt(): OpenAiProviderInterface
    {
        return $this->factory->createOpenAiProvider();
    }

    private static function loadEnvironment(): void
    {
        if (self::$envLoaded) {
            return;
        }

        $envFile = getcwd() . '/.aihotel.env';

        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lines as $line) {
                $line = trim($line);

                if (empty($line) || $line[0] === '#') {
                    continue;
                }

                $pos = strpos($line, '=');
                if ($pos === false) {
                    continue;
                }

                $key = trim(substr($line, 0, $pos));
                $value = trim(substr($line, $pos + 1));

                if (strlen($value) >= 2) {
                    if (($value[0] === '"' && str_ends_with($value, '"')) ||
                        ($value[0] === "'" && str_ends_with($value, "'"))) {
                        $value = substr($value, 1, -1);
                    }
                }

                $_ENV[$key] = $value;
                putenv("$key=$value");
            }
        }

        self::$envLoaded = true;
    }
}
