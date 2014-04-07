<p>Hey {{name}}! </p>
<p>Thank you for registering with Connectd. Please visit the link below so we can activate your account:</p>
<p><a href="<?= BASE_URL; ?>login.php?email={{email}}&email_code={{code}}"><?= BASE_URL; ?>login.php?email={{email}}&email_code={{$emailCode}}</a></p>
<p>-- Connectd team</p>
<p><a href='http://connectd.io'>www.connectd.io</a></p>
<img width='180' src="<?= BASE_URL; ?>assets/img/logo-email.jpg" alt="Connectd.io logo">