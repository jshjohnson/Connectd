<?php  
	// Login page
	include_once("inc/header-designer.php");
	include_once("inc/functions.php"); 
	include_once("inc/errors.php"); 
	
	// Form Vaidation
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$username= trim($_POST['email']);
	$password = trim($_POST['password']);

	if ($username&&$password){
		session_start(); require_once("inc/db_connect.php");
		mysqli_select_db($db_server, $db_database) or die("Couldn't find db");
		$username = clean_string($db_server, $username); 
		$password = clean_string($db_server, $password);
		$query = "SELECT * FROM connectdDB.designers WHERE username='$username'"; 
		$result = mysqli_query($db_server, $query);
		
		if($row = mysqli_fetch_array($result)){
			$db_username = $row['username'];
			$db_password = $row['password'];
			$DBID = $row['ID'];
				if($username==$db_username&&salt($password)==$db_password){
					$_SESSION['username']=$username;
					$_SESSION['userID']=$DBID;
					$_SESSION['logged']="logged";
					header('Location: designer.php');
				}else{
                  $message = "<h4 class=\"left\">Incorrect password!</h4>";
                }
        }else{
	        $message = "<h4 class=\"left\">That user does not exist!" . " Please <a href='index.php'>try again</a></h4>";
       } 
       mysqli_free_result($result);	
       require_once("inc/db_close.php");
	}else{
		$message = "";
	}
	
?>
	<section>
		<div class="section-heading color-blue">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
						<blockquote class="intro-quote text-center">
							The beginning of something special...
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 form-overlay">
				<?php echo $message; ?>
				<form method="post" action="signup-design.php">
					<input type="text" name="firstname" required placeholder="First name" class="field-1-2 float-left">
					<input type="text" name="firstname" required placeholder="Surname" class="field-1-2 float-right">
					<input type="email" name="email" required placeholder="Email">
					<input type='password' name='password' required placeholder="Password" class="field-1-2 float-left">
					<input type='password' name='repeatpassword' required placeholder="Repeat Password" class="field-1-2 float-right">
					<input type="text" name="job" required placeholder="Job Title">
					<input type="number" name="age" required placeholder="Age" class="field-1-2 float-left">
					<input type="number" name="experience" required placeholder="Years Experience" class="field-1-2 float-right">
					<textarea name="about" cols="30" rows="10" placeholder="A little about you..."></textarea>
					<div class="button-container">
		            	<input class="submit" type="submit" value="Apply for your place">						
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once("inc/footer.php"); ?>