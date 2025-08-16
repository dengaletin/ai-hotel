<?php

declare(strict_types=1);

namespace AiHotel\Providers\OpenAi;

use AiHotel\Dto\Request\OpenAi\Request;
use AiHotel\Dto\Response\OpenAi\Response;
use AiHotel\Enum\Providers;
use AiHotel\Exceptions\AiHotelException;
use Exception;

class OpenAiProvider implements OpenAiProviderInterface
{
    private const string API_URL = 'https://api.openai.com/v1/chat/completions';

    public function __construct(
        private readonly string $apiKey,
        private readonly int $timeout = 30
    ) {}

    public function getName(): string
    {
        return Providers::OPENAI->value;
    }

    public function isAvailable(): bool
    {
        return !empty($this->apiKey) && extension_loaded('curl');
    }

    /**
     * @throws AiHotelException
     */
    public function chat(Request $request): Response
    {
        try {
            return $this->sendRequest($request);
        } catch (AiHotelException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new AiHotelException(Providers::OPENAI->value . ' API request failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * @throws AiHotelException
     */
    private function sendRequest(Request $request): Response
    {
        $payload = $request->toArray();

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => self::API_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey,
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new AiHotelException("cURL error: {$error}");
        }

        curl_close($ch);

        if ($response === false) {
            throw new AiHotelException('Failed to get response from ' . Providers::OPENAI->value . ' API');
        }

        $data = json_decode($response, true);

        if ($httpCode !== 200) {
            $error = $data['error']['message'] ?? 'Unknown API error';

            return new Response(false, null, null, null, $error);
        }

        $content = $data['choices'][0]['message']['content'] ?? null;
        $tokensUsed = $data['usage']['total_tokens'] ?? null;

        return new Response(
            success: true,
            content: $content,
            tokensUsed: $tokensUsed,
            model: $request->model->value,
        );
    }
}
