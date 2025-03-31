<?php
// Assume this file both handles the form and displays the Google Form after verification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recaptchaResponse = $_POST['g-recaptcha-response'];
    $secretKey = '6LeVaQUrAAAAAJOY8di188XEynmgqRK_VSCnxSY5';  // Replace with your actual secret key
    $remoteIp = $_SERVER['REMOTE_ADDR'];

    // Prepare data for POST request
    $data = [
        'secret'   => $secretKey,
        'response' => $recaptchaResponse,
        'remoteip' => $remoteIp
    ];

    // Use cURL to send the request to Google reCAPTCHA server
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    $resultJson = json_decode($result);

    if ($resultJson->success) {
        // reCAPTCHA was successful; display the embedded Google Form
        echo '<iframe src="https://docs.google.com/forms/d/e/1FAIpQLSf3vjITSwppL6gx16lwVtOCOcmliNIS7aC-buV5_SQn0ogMiQ/viewform?embedded=true" width="640" height="800" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>';
    } else {
        // Verification failed; display an error message
        echo 'reCAPTCHA verification failed. Please try again.';
    }
} else {
    // Display the reCAPTCHA form if not submitted yet
    ?>
    <!DOCTYPE html>
    <html>
    <head>
      <title>Verify reCAPTCHA</title>
      <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
      <form action="" method="post">
        <div class="g-recaptcha" data-sitekey="6LeVaQUrAAAAALa-hI5v-ZyAoZLUDMJeYBvBw_bZ"></div>
        <br/>
        <input type="submit" value="Submit">
      </form>
    </body>
    </html>
    <?php
}
?>
