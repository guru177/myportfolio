<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

require dirname(__DIR__) . '/config.php';

$raw = file_get_contents('php://input') ?: '';
$payload = json_decode($raw, true);

if (!is_array($payload) || !isset($payload['messages']) || !is_array($payload['messages'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid payload']);
    exit;
}

$messages = [];
foreach ($payload['messages'] as $item) {
    if (!is_array($item)) {
        continue;
    }

    $role = $item['role'] ?? '';
    $content = trim((string) ($item['content'] ?? ''));

    if ($content === '' || !in_array($role, ['user', 'assistant'], true)) {
        continue;
    }

    $messages[] = [
        'role' => $role,
        'content' => mb_substr($content, 0, 500),
    ];
}

if ($messages === []) {
    http_response_code(400);
    echo json_encode(['error' => 'No messages']);
    exit;
}

$lastUser = '';
for ($i = count($messages) - 1; $i >= 0; $i--) {
    if ($messages[$i]['role'] === 'user') {
        $lastUser = $messages[$i]['content'];
        break;
    }
}

$chatConfig = $config['ai_chat'];
$apiKey = trim((string) ($chatConfig['api_key'] ?? ''));

if ($apiKey !== '') {
    $reply = askOpenAi($apiKey, (string) $chatConfig['model'], (string) $chatConfig['system_prompt'], $messages);
    if ($reply !== null) {
        echo json_encode(['reply' => $reply]);
        exit;
    }
}

echo json_encode(['reply' => fallbackReply($lastUser, $config)]);

function askOpenAi(string $apiKey, string $model, string $systemPrompt, array $messages): ?string
{
    $apiMessages = [['role' => 'system', 'content' => $systemPrompt]];
    foreach ($messages as $message) {
        $apiMessages[] = $message;
    }

    $body = json_encode([
        'model' => $model !== '' ? $model : 'gpt-4o-mini',
        'messages' => $apiMessages,
        'max_tokens' => 280,
        'temperature' => 0.6,
    ]);

    if ($body === false) {
        return null;
    }

    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    if ($ch === false) {
        return null;
    }

    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ],
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 25,
    ]);

    $response = curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false || $status < 200 || $status >= 300) {
        return null;
    }

    $data = json_decode($response, true);
    $content = $data['choices'][0]['message']['content'] ?? null;

    return is_string($content) && $content !== '' ? trim($content) : null;
}

function fallbackReply(string $message, array $config): string
{
    $text = mb_strtolower($message);
    $author = (string) ($config['author'] ?? 'Guruprasad');
    $email = (string) ($config['email'] ?? 'hello@guru.dev');
    $location = (string) ($config['location'] ?? 'Kochi, Kerala');

    if ($text === '') {
        return "Hi! I'm {$author}'s portfolio assistant. Ask about web apps, Laravel, Node, or hiring.";
    }

    if (preg_match('/\b(hi|hello|hey|good morning|good evening)\b/u', $text)) {
        return "Hello! I'm here to help you learn about {$author}'s work as a full stack webdeveloper in {$location}.";
    }

    if (preg_match('/\b(hire|developer|freelance|project|work with|need a dev|webapp|web app|website)\b/u', $text)) {
        return "{$author} builds modern web apps and websites — Laravel, Node, PHP, Electron, and clean frontends. Reach out at {$email} to discuss your project.";
    }

    if (preg_match('/\b(laravel|node|electron|php|html|stack|tech)\b/u', $text)) {
        return "Stack highlights: Laravel & PHP for backends, Node for APIs and tooling, Electron for desktop apps, and semantic HTML/CSS for polished UIs.";
    }

    if (preg_match('/\b(where|location|kochi|kerala|based)\b/u', $text)) {
        return "{$author} is based in {$location} and works with clients remotely.";
    }

    if (preg_match('/\b(contact|email|reach|talk)\b/u', $text)) {
        return "You can email {$author} directly at {$email}.";
    }

    if (preg_match('/\b(price|cost|rate|budget|charge)\b/u', $text)) {
        return 'Pricing depends on scope and timeline. Share your idea at ' . $email . ' for a tailored quote.';
    }

    return "Good question! {$author} is a full stack webdeveloper focused on reliable delivery and clean UX. For specifics, email {$email} or ask about services, stack, or location.";
}
