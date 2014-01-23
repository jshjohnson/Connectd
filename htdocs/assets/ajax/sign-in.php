<?php
	require_once("../../config/config.php");
	include_once(ROOT_PATH . "inc/functions.php"); 
	include_once(ROOT_PATH . "inc/login.php");
	include_once(ROOT_PATH . "inc/errors.php");
?>
<section class='overlay'>
	<div class='overlay__inner overlay__inner--small'> 
		<a href="" class="cancel-trigger"><i class="icon--cancel"></i></a>
		<h2 class='overlay__title'>Sign In</h2>
		<form method="post" action="<?php echo BASE_URL; ?>sign-in.php" autocomplete="off">
			<input type="email" name="email" placeholder="Email" value="<?php echo $_COOKIE['remember_me']; ?>">
			<input type='password' name='password' placeholder="Password">
			<fieldset class="checkbox float-left">
				<label>
					<input type="checkbox" value="1" name="remember" 
						<?php if(isset($_COOKIE['remember_me'])) {
							echo 'checked="checked"';
						}
						else {
							echo '';
						}
						?>>
					Remember me
				</label>
	        </fieldset>
	       	<a class="forgot float-right" href="#">Forgot password?</a>
			<div class="button-container clear">
            	<input class="submit" name="submit" type="submit" value='Sign In'>					
			</div>
        </form>
	</div>
</section>