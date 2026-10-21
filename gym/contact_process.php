<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

header('Content-Type: application/json; charset=utf-8');

function respond(int $status, array $body): void
{
    http_response_code($status);
    echo json_encode($body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    respond(405, ['success' => false, 'message' => 'This endpoint accepts POST requests only.']);
}

$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$subject = trim((string) ($_POST['subject'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

if (trim((string) ($_POST['website'] ?? '')) !== '') {
    respond(200, ['success' => true, 'message' => 'Thank you. Your message has been sent.']);
}

if (
    mb_strlen($name) < 2 || mb_strlen($name) > 100 ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254 ||
    mb_strlen($subject) < 3 || mb_strlen($subject) > 150 ||
    mb_strlen($message) < 10 || mb_strlen($message) > 5000
) {
    respond(422, ['success' => false, 'message' => 'Please check the form fields and try again.']);
}

$mailConfig = require __DIR__ . '/config/mail.php';
$requiredConfig = ['host', 'username', 'password', 'from_email', 'from_name', 'to_email'];
foreach ($requiredConfig as $key) {
    if (!isset($mailConfig[$key]) || trim((string) $mailConfig[$key]) === '') {
        error_log('Contact form email is not configured. Missing BRABUS_SMTP_* or BRABUS_CONTACT_TO settings.');
        respond(503, ['success' => false, 'message' => 'The contact form is not configured yet. Please try again later.']);
    }
}

$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (!is_file($autoloadPath)) {
    error_log('Contact form email dependency is missing. Run Composer install in the gym directory.');
    respond(503, ['success' => false, 'message' => 'The contact form is temporarily unavailable. Please try again later.']);
}

require $autoloadPath;

$escape = static function (string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
};

$safeSubject = preg_replace('/[\r\n]+/', ' ', $subject);
$htmlMessage = nl2br($escape($message), false);
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = $mailConfig['host'];
    $mail->Port = (int) ($mailConfig['port'] ?? 587);
    $mail->SMTPAuth = true;
    $mail->Username = $mailConfig['username'];
    $mail->Password = $mailConfig['password'];
    $mail->SMTPSecure = $mailConfig['encryption'] ?? PHPMailer::ENCRYPTION_STARTTLS;
    $mail->CharSet = PHPMailer::CHARSET_UTF8;
    $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
    $mail->addAddress($mailConfig['to_email']);
    $mail->addReplyTo($email, $name);
    $mail->isHTML(true);
    $mail->Subject = 'Brabus website contact: ' . $safeSubject;
    $mail->Body = '<h2>New message from the Brabus website</h2>'
        . '<p><strong>Name:</strong> ' . $escape($name) . '</p>'
        . '<p><strong>Email:</strong> ' . $escape($email) . '</p>'
        . '<p><strong>Subject:</strong> ' . $escape($safeSubject) . '</p>'
        . '<p><strong>Message:</strong><br>' . $htmlMessage . '</p>';
    $mail->AltBody = "Name: {$name}\nEmail: {$email}\nSubject: {$safeSubject}\n\n{$message}";
    $mail->send();

    respond(200, ['success' => true, 'message' => 'Thank you. Your message has been sent.']);
} catch (Exception $exception) {
    error_log('Unable to send Brabus contact email: ' . $exception->getMessage());
    respond(500, ['success' => false, 'message' => 'We could not send your message right now. Please try again later.']);
}