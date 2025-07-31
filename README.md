# 🤖 AiHotel - Simple AI Client for PHP

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.4-8892BF.svg)](https://php.net/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Clean, simple, and powerful PHP client for OpenAI GPT. Built with modern PHP 8.4+ features, strict types, and developer happiness in mind.

## ✨ Why AiHotel?

- **Zero Configuration Hassle** - Just add your API key and go
- **Conversation History** - Built-in chat history management
- **Smart Error Handling** - Clear exceptions with helpful messages
- **Modern PHP** - Uses latest PHP features

## 🚀 Quick Start

### Installation

```bash
composer require aihotel/ai-client
```

### Setup

Create `.aihotel.env` in your project root:

```env
OPENAI_API_KEY=sk-your-openai-api-key-here
```

### Your First Chat

```php

$client = new AiHotelClient();

$request = new Request(
    message: 'Explain quantum computing in simple terms',
    model: Model::GPT_4,
    temperature: 0.7
);

$response = $client->gpt()->chat($request);

if ($response->isSuccess()) {
    echo $response->getContent();
    echo "\nTokens used: " . $response->getTokensUsed();
} else {
    echo "Error: " . $response->getError();
}
```

That's it! 🎉

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
    history: $history
);

$response = $client->gpt()->chat($request);
// Will respond: "Your name is John!"
```

### Custom Parameters

```php
$request = new Request(
    message: 'Generate creative story ideas',
    model: Model::GPT_4,
    temperature: 1.2,  // More creative
    maxTokens: 500     // Limit response length
);
```

## 🎯 Available Models

```php
use AiHotel\Enum\OpenAi\Model;

Model::GPT_4          // Most capable model
Model::GPT_4_TURBO    // Faster and cheaper than GPT-4
Model::GPT_3_5_TURBO  // Fast and cost-effective
```

## 🛡️ Error Handling

The library provides specific exceptions for different scenarios:

```php

try {
    $response = $client->gpt()->chat($request);
} catch (OpenAiApiKeyMissingException $e) {
    echo "Please add your OpenAI API key to .aihotel.env file";
} catch (AiHotelException $e) {
    echo "API Error: " . $e->getMessage();
}
```

## 📋 Response Information

Every response contains useful metadata:

```php
$response = $client->gpt()->chat($request);

if ($response->isSuccess()) {
    echo "Content: " . $response->getContent();
    echo "Tokens used: " . $response->getTokensUsed();
    echo "Model: " . $response->getModel();
} else {
    echo "Error: " . $response->getError();
}
```

## 🔧 Advanced Features

### History Builder

Build complex conversations easily:

```php
use AiHotel\Services\Builders\OpenAi\HistoryBuilder;
use AiHotel\Enum\OpenAi\Role;

$historyBuilder = new HistoryBuilder();

// Add messages
$historyBuilder
    ->addMessage(Role::USER, 'Hello!')
    ->addMessage(Role::ASSISTANT, 'Hi there! How can I help?');

// Clear history if needed
$historyBuilder->clear();

// Get raw messages array
$messages = $historyBuilder->getMessages();

// Build History object
$history = $historyBuilder->build();
```

### Provider Availability

Check if OpenAI is available before making requests:

```php
$provider = $client->gpt();

if ($provider->isAvailable()) {
    $response = $provider->chat($request);
} else {
    echo "OpenAI provider is not available";
}
```

## 📁 Project Structure

```
src/
├── Services/
│   ├── AiHotelClient.php      # Main client
│   └── Builders/              # Helper builders
├── Providers/
│   └── OpenAi/               # OpenAI implementation
├── Dto/
│   ├── Request/              # Request objects
│   └── Response/             # Response objects
├── Enum/                     # Type-safe enums
└── Exceptions/               # Custom exceptions
```

## 🔑 Getting Your API Key

1. Go to [OpenAI Platform](https://platform.openai.com/api-keys)
2. Create an account or sign in
3. Generate a new API key
4. Add it to your `.aihotel.env` file

## 📦 Requirements

- PHP 8.4 or higher
- cURL extension

## 🤝 Contributing

Found a bug? Have a feature idea? We'd love your help!

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## 📄 License

MIT License - feel free to use this in your projects!

---

**Made with ❤️ for the PHP community**

*Stop wrestling with AI APIs and start building amazing things!*
