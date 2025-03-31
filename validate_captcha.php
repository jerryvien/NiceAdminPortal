<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptcha_secret = '6LeVaQUrAAAAAJOY8di188XEynmgqRK_VSCnxSY5';
    $recaptcha_response = $_POST['g-recaptcha-response'];

    if (empty($recaptcha_response)) {
        die('Please complete the CAPTCHA.');
    }

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $responseKeys = json_decode($response, true);

    if ($responseKeys["success"]) {
        // Redirect to your Google Form
        header("Location: https://docs.google.com/forms/d/e/1FAIpQLSf3vjITSwppL6gx16lwVtOCOcmliNIS7aC-buV5_SQn0ogMiQ/viewform");
        exit();
    } else {
        echo "CAPTCHA verification failed. Please try again.";
    }
}
