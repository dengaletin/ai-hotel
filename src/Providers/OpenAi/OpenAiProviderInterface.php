<?php

declare(strict_types=1);

namespace AiHotel\Providers\OpenAi;

use AiHotel\Dto\Request\OpenAi\Request;
use AiHotel\Dto\Response\OpenAi\Response;
use AiHotel\Exceptions\AiHotelException;
use AiHotel\Providers\AiProviderInterface;

interface OpenAiProviderInterface extends AiProviderInterface
{
    /**
     * @throws AiHotelException
     */
    public function chat(Request $request): Response;
}
