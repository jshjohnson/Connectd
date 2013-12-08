<?php
include_once("inc/functions.php"); 
include_once("inc/errors.php"); 
include_once("inc/login.php");
?>
<section class='overlay'>
	<div class='overlay__inner'> 
		<h2 class='overlay__title'>Sign In</h2>
		<?php echo $message; ?>
		<form method="post" action="sign-in.php" autocomplete="off">
			<input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" class="field-1-2">
			<input type='password' name='password' placeholder="Password" class="field-1-2 float-right">
			<div class="button-container">
            	<input class="submit" name="submit" type="submit" value='Sign In'>					
			</div>
        </form>
	</div>
</section>