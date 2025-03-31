<!-- Google reCAPTCHA v3 -->
<script src="https://www.google.com/recaptcha/api.js?render=YOUR_SITE_KEY"></script>

<form action="validate_captcha.php" method="post" id="recaptchaForm">
    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
    <input type="submit" value="Submit">
</form>

<script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6LdLZAUrAAAAAPZCS2ZdeOQeGuQDYVHD1qmuxGD_', {action: 'submit'}).then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
        });
    });
</script>
