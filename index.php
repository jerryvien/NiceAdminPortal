<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Google Form with reCAPTCHA</title>
    <!-- Load reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <h1>Google Form Access with CAPTCHA</h1>
    <form action="validate_captcha.php" method="post">
        <!-- Google reCAPTCHA Widget -->
        <div class="g-recaptcha" data-sitekey="6LeVaQUrAAAAALa-hI5v-ZyAoZLUDMJeYBvBw_bZ"></div>
        <br>
        <input type="submit" value="Proceed to Google Form">
    </form>
</body>
</html>
