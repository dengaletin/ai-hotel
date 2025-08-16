# 🤖 AiHotel - Simple AI Client for PHP

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.4-8892BF.svg)](https://php.net/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Clean, simple, and powerful PHP client for OpenAI GPT. Built with modern PHP 8.4+ features, strict types, and developer happiness in mind.

## ✨ Why AiHotel?

- **Zero Configuration Hassle** - Just add your API key and go
- **Conversation History** - Built-in chat history management
- **Exception-Based Error Handling** - Clear exceptions with helpful messages
- **Modern PHP** - Uses latest PHP 8.4+ features with strict types
- **Clean API** - Simple, intuitive interface

## 🚀 Quick Start

### Installation

```bash
composer require aihotel/ai-client
```

### Your First Chat

```php
use AiHotel\Services\AiHotelClient;
use AiHotel\Dto\Request\OpenAi\Request;
use AiHotel\Enum\OpenAi\Model;
use AiHotel\Exceptions\AiHotelException;

try {
    // Create client with your OpenAI API key
    $client = AiHotelClient::create([
        'openai_api_key' => 'sk-your-openai-api-key-here'
    ]);

    $request = new Request(
        message: 'Explain quantum computing in simple terms',
        model: Model::GPT_4
    );

    $response = $client->gpt()->chat($request);
    echo $response->getContent();
    
} catch (AiHotelException $e) {
    echo "Error: " . $e->getMessage();
}
```

## 💬 Chat with History

```php
use AiHotel\Services\Builders\OpenAi\HistoryBuilder;
use AiHotel\Enum\OpenAi\Role;

try {
    $client = AiHotelClient::create([
        'openai_api_key' => 'sk-your-openai-api-key-here'
    ]);

    // Build conversation history
    $history = HistoryBuilder::create()
        ->addMessage(Role::SYSTEM, 'You are a helpful coding assistant')
        ->addMessage(Role::USER, 'How do I create a PHP class?')
        ->addMessage(Role::ASSISTANT, 'To create a PHP class, use the `class` keyword...')
        ->addMessage(Role::USER, 'Can you show me an example?')
        ->build();

    $request = new Request(
        message: 'Make it a simple User class',
        history: $history,
        model: Model::GPT_4,
        temperature: 0.7
    );

    $response = $client->gpt()->chat($request);
    echo $response->getContent();
    
} catch (AiHotelException $e) {
    echo "Error: " . $e->getMessage();
}
```

## 📚 Usage Examples

### Simple Chat

```php
use AiHotel\Dto\Request\OpenAi\Request;
use AiHotel\Enum\OpenAi\Model;

$request = new Request(
    message: 'Write a haiku about PHP',
    model: Model::GPT_4_TURBO
);

$response = $client->gpt()->chat($request);
echo $response->getContent();
```

### Chat with System Prompt

```php
$request = new Request(
    message: 'How do I center a div?',
    model: Model::GPT_4,
    systemPrompt: 'You are a senior frontend developer. Be concise and practical.'
);

$response = $client->gpt()->chat($request);
echo $response->getContent();
```

### Conversation with History

```php
use AiHotel\Services\Builders\OpenAi\HistoryBuilder;
use AiHotel\Enum\OpenAi\Role;

// Build conversation history
$history = (new HistoryBuilder())
    ->addMessage(Role::USER, 'My name is John')
    ->addMessage(Role::ASSISTANT, 'Nice to meet you, John!')
    ->addMessage(Role::USER, 'What programming languages do you recommend?')
    ->addMessage(Role::ASSISTANT, 'For beginners, I recommend starting with Python...')
    ->build();

// Continue the conversation
$request = new Request(
    message: 'What was my name again?',
    history: $history,
    model: Model::GPT_4
);

$response = $client->gpt()->chat($request);
// Will respond: "Your name is John!"
echo $response->getContent();
```

### Custom Parameters

```php
$request = new Request(
    message: 'Generate creative story ideas',
    model: Model::GPT_4,
    temperature: 1.2,  // More creative
    maxTokens: 500     // Limit response length
);

$response = $client->gpt()->chat($request);
echo $response->getContent();
```

## 🎯 Available Models

```php
use AiHotel\Enum\OpenAi\Model;

Model::GPT_4          // Most capable model
Model::GPT_4_TURBO    // Faster and cheaper than GPT-4
Model::GPT_3_5_TURBO  // Fast and cost-effective
```

## 🛡️ Exception-Based Error Handling

The library uses exceptions for clean error handling:

```php
use AiHotel\Exceptions\AiHotelException;

try {
    $response = $client->gpt()->chat($request);
    echo $response->getContent();
    
} catch (AiHotelException $e) {
    // Handle API errors
    echo "API Error: " . $e->getMessage();
    
} catch (Exception $e) {
    // Handle unexpected errors
    echo "Unexpected error: " . $e->getMessage();
}
```

## 📋 Response Information

Every successful response contains useful metadata:

```php
$response = $client->gpt()->chat($request);

echo "Content: " . $response->getContent();
echo "Tokens used: " . $response->getTokensUsed();
echo "Model: " . $response->getModel();
```

## 🔧 Advanced Features

### History Builder

Build complex conversations easily:

```php
use AiHotel\Services\Builders\OpenAi\HistoryBuilder;
use AiHotel\Enum\OpenAi\Role;

$historyBuilder = new HistoryBuilder();

// Add messages fluently
$historyBuilder
    ->addMessage(Role::SYSTEM, 'You are a helpful assistant')
    ->addMessage(Role::USER, 'Hello!')
    ->addMessage(Role::ASSISTANT, 'Hi there! How can I help?')
    ->addMessage(Role::USER, 'Tell me about PHP');

// Build the history array
$history = $historyBuilder->build();

// Use in request
$request = new Request(
    message: 'What are the benefits of PHP 8.4?',
    history: $history,
    model: Model::GPT_4
);
```

### Alternative History Builder Syntax

```php
// Static factory method
$history = HistoryBuilder::create()
    ->addMessage(Role::USER, 'Start conversation')
    ->build();
```

## 🚀 Best Practices

### 1. Always Use Try-Catch

```php
try {
    $response = $client->gpt()->chat($request);
    // Process successful response
    echo $response->getContent();
} catch (AiHotelException $e) {
    // Log error and show user-friendly message
    error_log($e->getMessage());
    echo "Sorry, I couldn't process your request right now.";
}
```

### 2. Manage Token Usage

```php
$response = $client->gpt()->chat($request);

// Monitor token usage for cost control
$tokensUsed = $response->getTokensUsed();
if ($tokensUsed > 1000) {
    // Log high usage or notify admin
    error_log("High token usage: {$tokensUsed} tokens");
}
```

### 3. Use System Prompts for Consistency

```php
$systemPrompt = 'You are a helpful coding assistant. ' .
               'Always provide working code examples and explain your solutions clearly.';

$request = new Request(
    message: $userMessage,
    model: Model::GPT_4,
    systemPrompt: $systemPrompt
);
```

## 🔧 Configuration

### Environment Variables

You can use environment variables for API keys:

```php
// .env file
OPENAI_API_KEY=sk-your-openai-api-key-here

// PHP code
$client = AiHotelClient::create([
    'openai_api_key' => $_ENV['OPENAI_API_KEY'] ?? getenv('OPENAI_API_KEY')
]);
```

### Custom Timeout

```php
// Configure longer timeout for complex requests
$client = AiHotelClient::create([
    'openai_api_key' => 'sk-your-key',
    'timeout' => 60  // 60 seconds
]);
```

## 📖 API Reference

### Request Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `message` | `string` | Yes | The user message to send |
| `model` | `Model` | No | OpenAI model to use (default: GPT_3_5_TURBO) |
| `systemPrompt` | `string` | No | System prompt to set behavior |
| `history` | `array` | No | Conversation history |
| `temperature` | `float` | No | Creativity level (0.0-2.0) |
| `maxTokens` | `int` | No | Maximum response length |

### Response Properties

| Property | Type | Description |
|----------|------|-------------|
| `content` | `string\|null` | The AI response content |
| `tokensUsed` | `int\|null` | Number of tokens consumed |
| `model` | `string\|null` | Model used for the response |

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🔗 Links

- [OpenAI API Documentation](https://platform.openai.com/docs)
- [PHP 8.4 Documentation](https://www.php.net/releases/8.4/en.php)
