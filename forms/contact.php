<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}

$to = 'Contact@adbizzmedia.com';
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$headers = "From: $name <$email>" . "\r\n" .
           "Reply-To: $email" . "\r\n" .
           "X-Mailer: PHP/" . phpversion();

$full_message = "Name: $name\nEmail: $email\nMessage:\n$message";

if (mail($to, $subject, $full_message, $headers)) {
    echo "OK"; // just return OK
} else {
    http_response_code(500);
    echo "Error sending message.";
}
?>