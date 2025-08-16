<?php

declare(strict_types=1);

namespace AiHotel\Dto\Response\OpenAi;

readonly class Response
{
    public function __construct(
        public ?string $content = null,
        public ?int $tokensUsed = null,
        public ?string $model = null,
    ) {}

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getTokensUsed(): ?int
    {
        return $this->tokensUsed;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }
}
