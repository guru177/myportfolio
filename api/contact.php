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

if (!is_array($payload)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid payload']);
    exit;
}

$name = trim((string) ($payload['name'] ?? ''));
$email = trim((string) ($payload['email'] ?? ''));
$message = trim((string) ($payload['message'] ?? ''));

if ($name === '' || $email === '' || $message === '') {
    http_response_code(422);
    echo json_encode(['error' => 'All fields are required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['error' => 'Invalid email']);
    exit;
}

$name = mb_substr($name, 0, 120);
$email = mb_substr($email, 0, 160);
$message = mb_substr($message, 0, 4000);

$to = $config['email'];
$subject = 'Portfolio inquiry from ' . $name;
$body = "Name: {$name}\nEmail: {$email}\n\nMessage:\n{$message}\n";
$headers = [
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'From: ' . $to,
    'Reply-To: ' . $email,
    'X-Mailer: PHP/' . PHP_VERSION,
];

$mailSent = @mail($to, $subject, $body, implode("\r\n", $headers));

echo json_encode([
    'ok' => true,
    'mail_sent' => (bool) $mailSent,
]);
