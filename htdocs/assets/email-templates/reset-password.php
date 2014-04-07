<p>Hey {{name}}! </p>
<p>Please click the link below to reset your password:</p>
<p><a href="<?= BASE_URL; ?>recover.php?email={{email}}&generated_string={{string}}"></a></p>
<p>We will generate a new password for you and send it back to your email.</p>
<p>-- Connectd team</p>
<p><a href='http://connectd.io'>www.connectd.io</a></p>
<img width='180' src="<?= BASE_URL; ?>assets/img/logo-email.jpg" alt="Connectd.io logo">