<?php
// Simulated email sending with local logging

$to = "test@example.com";
$subject = "Test email (simulated)";
$message = "This is a simulated test email from HireZone using a fake local sender.";

// Optional: add sender info
$from = "no-reply@hirezone.local";

// Create log content
$logEntry = "[" . date("Y-m-d H:i:s") . "] TO: $to | FROM: $from | SUBJECT: $subject | MESSAGE: $message" . PHP_EOL;

// Ensure log directory exists
$logDir = __DIR__ . "/logs";
if (!file_exists($logDir)) {
    mkdir($logDir, 0777, true);
}

// Save to log file
file_put_contents($logDir . "/email_log.txt", $logEntry, FILE_APPEND);

echo "Email simulated. Log entry saved to /logs/email_log.txt.";
