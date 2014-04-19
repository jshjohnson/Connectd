<?php
	require_once("config.php"); 
	require(ROOT_PATH . "core/init.php");

	$debug->showErrors();

	$pageTitle = "Change Password";
	$pageType = "Page";
	$section = "Blue";
	include(ROOT_PATH . "includes/header.inc.php");

?>
	<section>
		<div class="section-heading color-blue">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
						<blockquote class="intro-quote text-center">
							Change Password
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 content-overlay">
				<?php

					$currentPassword = $_POST['current_password'];
					$newPassword = $_POST['new_password'];
					$repeatNewPassword = $_POST['repeat_new_password'];

			        if(empty($_POST) === false) {
			           
			            if(empty($currentPassword) || empty($newPassword) || empty($repeatNewPassword)){
			 
			                $errors[] = 'All fields are required';
			 
			            }else if($bcrypt->verify($currentPassword, $sessionUser['password']) === true) {
			 
			                if (trim($newPassword) != trim($repeatNewPassword)) {
			                    $errors[] = 'Your new passwords do not match';
			                } else if (strlen($newPassword) < 6) { 
			                    $errors[] = 'Your password must be at least 6 characters';
			                } else if (strlen($newPassword) >18){
			                    $errors[] = 'Your password cannot be more than 18 characters long';
			                } 
			 
			            } else {
			                $errors[] = 'Your current password is incorrect';
			            }
			        }

		            if (empty($_POST) === false && empty($errors) === true) {
		                $users->changePassword($sessionUser['user_id'], $newPassword);
		                header('Location: change-password.php?success');
		            } else if (empty ($errors) === false) {               
		                echo '<p class="message message--error shake">' . implode('</p><p>', $errors) . '</p>';
		            }
				?>
				<?php if (isset($_GET['success']) === true && empty ($_GET['success']) === true ) {
		    		echo '<p class="message message--success fadeIn">Your password has been changed!</p>';
		    	} ?>
				<form action="<?= BASE_URL . "change-password.php"; ?>" method="post" autocomplete="off">
					<label for="current_password">Current password</label>
					<input type='password' name='current_password' placeholder="• • • • • • • •" value="<?php if (isset($currentPassword)) { echo htmlspecialchars($currentPassword); } ?>">
					<hr>
					<fieldset class="cf">
						<div class="field-1-2 float-left">
							<label for="new_password">New password</label>
							<input type='password' name='new_password' placeholder="• • • • • • • •" value="<?php if (isset($newPassword)) { echo htmlspecialchars($newPassword); } ?>">	
						</div>		
						<div class="field-1-2 float-right">
							<label for="repeat_new_passsword">Repeat password</label>
							<input type='password' name='repeat_new_password' placeholder="• • • • • • • •" value="<?php if (isset($repeatNewPassword)) { echo htmlspecialchars($repeatNewPassword); } ?>">
						</div>						
					</fieldset>
					<div class="btn-container clear">
						<input class="btn--left btn--green" name="submit" type="submit" value="Change password">
					</div>
				</form>
			</div>
		</div>
	</section>
<?php include(ROOT_PATH . "includes/footer.inc.php"); ?>