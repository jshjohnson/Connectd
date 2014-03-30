<?php
	require_once("../../config/config.php");
	require_once(ROOT_PATH . "core/init.php"); 
?>
<section class='overlay'>
	<div class='overlay__inner overlay__inner--small'> 
		<a href="" class="cancel-trigger"><i class="icon--cancel"></i></a>
		<h2 class='overlay__title'>Log In</h2>
		<form method="post" action="<?= BASE_URL; ?>login.php" autocomplete="off">
			<input type="email" name="email" placeholder="Email" value="<?= $_COOKIE['remember_me']; ?>" autofocus>
			<input type='password' name='password' placeholder="Password">
			<fieldset class="checkbox float-left">
				<label>
					<input type="checkbox" value="1" name="remember" 
					<?php 
						$rememberMe = array_key_exists('remember_me', $_COOKIE);
						if($rememberMe) { echo 'checked="checked"'; }?>>
					Remember me
				</label>
	        </fieldset>
	       	<a class="forgot float-right" href="<?= BASE_URL; ?>confirm-recover.php">Forgot password?</a>
			<div class="btn-container clear">
            	<input class="btn--green" name="submit" type="submit" value='Log In'>					
			</div>
        </form>
	</div>
</section>