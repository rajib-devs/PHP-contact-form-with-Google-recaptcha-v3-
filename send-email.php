<?php
// CONFIGURATION
$secretKey = "YOUR_SECRET_KEY"; // Replace with your secret key from Google
$to = "info@softclimax.com";
$fromEmail = "website@softclimax.com";

// Validate required fields
if (empty($_POST['contactPerson']) || empty($_POST['email']) || empty($_POST['g-recaptcha-response'])) {
    exit("Missing required fields.");
}

// Sanitize and collect form inputs
$name = isset($_POST['contactPerson']) ? filter_var(trim($_POST['contactPerson']), FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$contact = isset($_POST['number']) ? filter_var(trim($_POST['number']), FILTER_SANITIZE_SPECIAL_CHARS) : '';
$subject = isset($_POST['subject']) ? filter_var(trim($_POST['subject']), FILTER_SANITIZE_FULL_SPECIAL_CHARS) : 'No Subject';
$message = isset($_POST['message']) ? filter_var(trim($_POST['message']), FILTER_SANITIZE_FULL_SPECIAL_CHARS) : '';
$recaptchaToken = $_POST['g-recaptcha-response'];

// Verify reCAPTCHA
$recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
$data = [
    'secret' => $secretKey,
    'response' => $recaptchaToken
];

$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query($data)
    ]
];

$context = stream_context_create($options);
$verify = file_get_contents($recaptchaUrl, false, $context);
$response = json_decode($verify);

// Check score
if ($response->success && $response->score >= 0.5) {
    $emailMessage = "Name: $name\nEmail: $email\nSubject: $subject\nContact Number: $contact\nMessage:\n$message";

    $headers = "From: $fromEmail\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $subject, $emailMessage, $headers)) {
        header("Location: index.html"); // Redirect to homepage after success
        exit;
    } else {
        http_response_code(500);
        echo "Something went wrong. Please try again later.";
    }
} else {
    http_response_code(400);
    echo "reCAPTCHA failed. Please try again.";
}
?>
