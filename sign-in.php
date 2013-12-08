<?php
include_once("inc/header.php");
include_once("inc/functions.php"); 
include_once("inc/errors.php"); 

//Form Vaidation
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$submit = trim($_POST['submit']);

if ($submit=='Sign In'){
			
    if($email == ""){
        $message="Please enter your email"; 
    }else if($password == ""){
        $message="Please enter your password"; 
    }else{
		session_start(); require_once("inc/db_connect.php");
		mysqli_select_db($db_server, $db_database) or die("Couldn't find db");
		$email = clean_string($db_server, $email); 
		$password = clean_string($db_server, $password);
		$query = "SELECT * FROM connectdDB.designers WHERE email='$email'"; 
		$result = mysqli_query($db_server, $query);
		
		if($row = mysqli_fetch_array($result)){
			$db_email = $row['email'];
			$db_password = $row['password'];
			$DBID = $row['ID'];
				if($email==$db_email&&salt($password)==$db_password){
					$_SESSION['email']=$email;
					$_SESSION['userID']=$DBID;
					$_SESSION['logged']="logged";
					header('Location: designer.php');
				}else{
	              $message = "Incorrect password!";
	            }
	    }else{
	        $message = "That user does not exist!" . " Please try again";
	   } 
	   mysqli_free_result($result);	
	   require_once("inc/db_close.php");
	}
}
	
?>
	<header class="header header-blue--alt zero-bottom cf">
		<div class="container">
			<h1 class="page-title">
				Sign In
			</h1>
			<h2 class="page-logo header-logo">
				<a href="index.php">connectd</a>
			</h2>
		</div>
	</header>
	<section>
		<div class="section-heading color-blue">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
						<blockquote class="intro-quote text-center">
							Sign in
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
				<form method="post" action="sign-in.php" autocomplete="off">
					<input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>" class="field-1-2">
					<input type='password' name='password' placeholder="Password" class="field-1-2 float-right">
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Sign In'>					
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once("inc/footer.php"); ?>