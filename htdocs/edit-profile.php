<?php
	require_once("config.php"); 
	require(ROOT_PATH . "core/init.php");

	$debug->showErrors();

	$pageTitle = "Edit Profile";
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
							Edit Profile
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
		    if (isset($_GET['success']) && empty($_GET['success'])) {
		        echo '<p class="message message--success fadeIn">Your details have been updated!</p>';	        
		    } else {
 
	            if(empty($_POST) === false) {		
				
					if (isset($_POST['firstname']) && !empty ($_POST['firstname'])){ // We only allow names with alphabets
						if (ctype_alpha($_POST['firstname']) === false) {
							$errors[] = 'Please enter your first fame with only letters!';
						}	
					} else {
						$errors[] = 'Please enter your first name';
					}

					if (isset($_POST['lastname']) && !empty ($_POST['lastname'])){
						if (ctype_alpha($_POST['lastname']) === false) {
						$errors[] = 'Please enter your last name with only letters!';
						}	
					} else {
						$errors[] = 'Please enter your last name';
					}

					if (empty($_POST['bio'])){
						$errors[] = 'Please enter a bio';
					}
					
					if (isset($_FILES['myfile']) && !empty($_FILES['myfile']['name'])) {// check if the user has uploaded a new file
						
						$name 			= $_FILES['myfile']['name']; // getting the name of the file
						$tmp_name 		= $_FILES['myfile']['tmp_name']; // getting the temporary file name.
						$allowed_ext 	= array('jpg', 'jpeg', 'png', 'gif', 'svg');// specifying the allowed extentions
						$a 				= explode('.', $name);
						$file_ext 		= strtolower(end($a)); unset($a);// getting the allowed extensions
						$file_size 		= $_FILES['myfile']['size'];
						$path 			= "assets/avatars";// the folder in which we store the profile pictures or avatars of the user.
						
						if (in_array($file_ext, $allowed_ext) === false) {
							$errors[] = 'Image file type not allowed';	
						}
						
						if ($file_size > 2097152) {
							$errors[] = 'File size must be under 2mb';
						}
						
					} else {
						$newpath = $user['image_location']; // if user did not upload a file, then use the one stored in the database
					}
	 
					if(empty($errors) === true) {
						
						if (isset($_FILES['myfile']) && !empty($_FILES['myfile']['name'])) {
					
							$newpath = $forms->fileNewPath($path, $name);
	 
							move_uploaded_file($tmp_name, $newpath);
	 
						}
								
						$firstName 	= htmlentities(trim($_POST['firstname']));
						$lastName 		= htmlentities(trim($_POST['lastname']));	
						$bio 			= htmlentities(trim($_POST['bio']));
						$imageLocation	= htmlentities(trim($newpath));
						
						$users->updateUser($firstName, $lastName, $bio, $imageLocation, $user_id);
						header('Location: edit-profile.php?success');
						exit();
					
					} else if (empty($errors) === false) {
						echo '<p class="message message--error shake">' . implode('</p><p>', $errors) . '</p>';	
					}	
	            }
	        }
    		?>
            <form action="<?= BASE_URL . "edit-profile.php"; ?>" method="post" enctype="multipart/form-data">
	            <div class="cf">
	           		<fieldset class="field-1-2 float-right">                
						<img src="<?= $sessionAvatar ?>" alt="Avatar" class="form__img">
					</fieldset>
	                <fieldset class="field-1-2 float-left">
	               	 <label for="myfile">Change profile picture</label>
	               	 <input type="file" name="myfile" class="float-right">
	                </fieldset>
                </div>
                <hr>
                <div class="cf">
	            	<fieldset class="field-1-2 float-left">
	                    <label>First name:</label>
	                    <input type="text" name="firstname" value="<?php if (isset($_POST['firstname']) ){echo htmlentities(strip_tags($_POST['firstname']));} else { echo $sessionUser['firstname']; }?>">
					</fieldset>
					<fieldset class="field-1-2 float-right">
	                    <label>Last name:</label>
	                    <input type="text" name="lastname" value="<?php if (isset($_POST['lastname']) ){echo htmlentities(strip_tags($_POST['lastname']));} else { echo $sessionUser['lastname']; }?>">
					</fieldset>
				</div>
				<fieldset class="cf">
                    <label>Bio:</label>
                    <textarea name="bio"><?php if (isset($_POST['bio']) ){echo htmlentities(strip_tags($_POST['bio']));} else { echo $sessionUser['bio']; }?></textarea>
					<div class="btn-container">
		            	<input class="btn--green" name="submit" type="submit" value="Update profile">						
					</div>
				</fieldset>
            </form>
			</div>
		</div>
	</section>
<?php include(ROOT_PATH . "includes/footer.inc.php"); ?>