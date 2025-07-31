<?php

declare(strict_types=1);

namespace AiHotel\Dto\Request\OpenAi;

use AiHotel\Enum\OpenAi\Model;
use AiHotel\Enum\OpenAi\Role;
use InvalidArgumentException;

readonly class Request
{
    private History $history;

    public function __construct(
        public string $message,
        public Model $model = Model::GPT_4,
        public float $temperature = 0.7,
        public ?int $maxTokens = null,
        public ?string $systemPrompt = null,
        ?History $history = null
    ) {
        if ($temperature < 0 || $temperature > 2) {
            throw new InvalidArgumentException('Temperature must be between 0 and 2');
        }

        $this->history = $history ?? new History();
    }

    public function toArray(): array
    {
        $messages = [];

        if ($this->systemPrompt !== null) {
            $messages[] = [
                'role' => Role::SYSTEM->value,
                'content' => $this->systemPrompt
            ];
        }

        foreach ($this->history->toArray() as $historyMessage) {
            $messages[] = $historyMessage;
        }

        $messages[] = [
            'role' => Role::USER->value,
            'content' => $this->message
        ];

        $payload = [
            'model' => $this->model->value,
            'messages' => $messages,
            'temperature' => $this->temperature,
        ];

        if ($this->maxTokens !== null) {
            $payload['max_tokens'] = $this->maxTokens;
        }

        return $payload;
    }
}
