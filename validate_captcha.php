<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptcha_secret = '6LdLZAUrAAAAABIrdc6BsblaZhZq0qLBk3USZoRs';
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Verify the CAPTCHA
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response");
    $responseKeys = json_decode($response, true);

    if(intval($responseKeys["success"]) !== 1) {
        echo "CAPTCHA verification failed. Please try again.";
    } else {
        echo "CAPTCHA verified successfully. You can proceed with your form submission.";
    }
} else {
    echo "Invalid request method.";
}
