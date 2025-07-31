<?php

declare(strict_types=1);

namespace AiHotel\Providers;

interface AiProviderInterface
{
    public function getName(): string;

    public function isAvailable(): bool;
}
