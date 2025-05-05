<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}

// change this to your email
$to = 'Contact@adbizzmedia.com';

$email = $_POST['email'] ?? '';

if (empty($email)) {
    http_response_code(400);
    echo "Email is required.";
    exit;
}

$subject = "New Subscription: " . $email;
$message = "New subscriber email: " . $email;

$headers = "From: no-reply@yourdomain.com\r\n";
$headers .= "Reply-To: " . $email . "\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo "OK"; // frontend can show success
} else {
    http_response_code(500);
    echo "Error sending email.";
}
?>