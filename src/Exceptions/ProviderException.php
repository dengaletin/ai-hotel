<?php

declare(strict_types=1);

namespace AiHotel\Exceptions;

use Throwable;

abstract class ProviderException extends AiHotelException
{
    public function __construct(
        protected readonly string $providerName,
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
