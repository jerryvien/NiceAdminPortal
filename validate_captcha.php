<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptcha_secret = '6LeVaQUrAAAAAJOY8di188XEynmgqRK_VSCnxSY5'; // Replace with your Secret Key
    $recaptcha_response = $_POST['g-recaptcha-response'];

    if (empty($recaptcha_response)) {
        die('Please complete the CAPTCHA.');
    }

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $responseKeys = json_decode($response, true);

    if ($responseKeys["success"]) {
        echo "CAPTCHA verified successfully. Proceeding to your form submission.";
    } else {
        echo "CAPTCHA verification failed. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
