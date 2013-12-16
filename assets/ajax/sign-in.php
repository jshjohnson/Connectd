<?php
	require_once("../../inc/config.php"); 
	include_once(ROOT_PATH . "inc/functions.php"); 
	include_once(ROOT_PATH . "inc/errors.php"); 
	include_once(ROOT_PATH . "inc/login.php");
?>
<section class='overlay'>
	<div class='overlay__inner overlay__inner--small'> 
		<a href="" class="cancel-trigger"><i class="icon--cancel"></i></a>
		<h2 class='overlay__title'>Sign In</h2>
		<?php echo $message; ?>
		<form method="post" action="<?php echo BASE_URL; ?>sign-in.php" autocomplete="off">
			<input type="email" name="email" placeholder="Email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
			<input type='password' name='password' placeholder="Password">
			<div class="button-container">
            	<input class="submit" name="submit" type="submit" value='Sign In'>					
			</div>
        </form>
	</div>
</section>