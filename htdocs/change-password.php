<?php
	require_once("config.php"); 
	require_once(ROOT_PATH . "core/init.php");

	$general->errors();

	$pageTitle = "Change Password";
	$pageType = "Page";
	$section = "Blue";
	include_once(ROOT_PATH . "includes/header.inc.php");

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
			        if(empty($_POST) === false) {
			           
			            if(empty($_POST['current_password']) || empty($_POST['new_password']) || empty($_POST['repeat_new_password'])){
			 
			                $errors[] = 'All fields are required';
			 
			            }else if($bcrypt->verify($_POST['current_password'], $user['password']) === true) {
			 
			                if (trim($_POST['new_password']) != trim($_POST['repeat_new_password'])) {
			                    $errors[] = 'Your new passwords do not match';
			                } else if (strlen($_POST['new_password']) < 6) { 
			                    $errors[] = 'Your password must be at least 6 characters';
			                } else if (strlen($_POST['new_password']) >18){
			                    $errors[] = 'Your password cannot be more than 18 characters long';
			                } 
			 
			            } else {
			                $errors[] = 'Your current password is incorrect';
			            }
			        }
			 
			        if (isset($_GET['success']) === true && empty ($_GET['success']) === true ) {
			    		echo '<p class="message message--success fadeIn">Your password has been changed!</p>';
			        } else {
			            if (empty($_POST) === false && empty($errors) === true) {
			                $users->changePassword($user['user_id'], $_POST['new_password']);
			                header('Location: change-password.php?success');
			            } else if (empty ($errors) === false) {               
			                echo '<p class="message message--error shake">' . implode('</p><p>', $errors) . '</p>';
			            }
			        ?>
						<form action="<?= BASE_URL . "change-password.php"; ?>" method="post" autocomplete="off">
							<label for="current_password">Current password</label>
							<input type='password' name='current_password' placeholder="• • • • • • • •" value="">
							<hr>
							<fieldset class="cf">
								<div class="field-1-2 float-left">
									<label for="new_password">New password</label>
									<input type='password' name='new_password' placeholder="• • • • • • • •" value="">	
								</div>		
								<div class="field-1-2 float-right">
									<label for="repeat_new_passsword">Repeat password</label>
									<input type='password' name='repeat_new_password' placeholder="• • • • • • • •" value="">
								</div>						
							</fieldset>
							<div class="btn-container clear">
								<input class="btn--left btn--green" name="submit" type="submit" value="Change password">
							</div>
						</form>
			    	<?php } ?> 
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>