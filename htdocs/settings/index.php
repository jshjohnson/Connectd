<?php 	
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");

	$pageTitle = "Settings";
	$section = "Settings";
	
	$general->loggedOutProtect();
	
	$sess_userID = $_SESSION['userID']; 
	if(trim($_POST['submit'])=='submit'){
		if(trim($_POST['delete'] )==1) {
			require_once(ROOT_PATH . "inc/db_connect.php");
			if (!$db_server){
				die("Unable to connect to MySQL: " . mysqli_connect_error($db_server));
                $db_status = "not connected";
            }else{
            	mysqli_select_db($db_server, DB_NAME) or die ("<h1>Couldn't find db</h1>");
            		
            	//DELETE record from users table
                $query = "DELETE FROM users WHERE ID=$sess_userID";
                mysqli_query($db_server, $query) or die("Delete 2 failed".mysqli_error($db_server));

            	//LOGOUT AND DESTROY SESSION
            	$_SESSION = array();
	        	session_destroy();
	        	header('Location: /');
            }
            require_once(ROOT_PATH . "inc/db_close.php");
    		}else{
    	 		header('location: home.php');
    	 	}
   		}
	include_once(ROOT_PATH . "inc/header.php");
?>  
	<header class="header header-blue--alt zero-bottom cf">
		<div class="container">
				<?php if (!isset($_SESSION['logged'])) :?>
				<h1 class="header__section header__section--title">Settings
					<a href="" class="login-trigger header__section--title__link">: Log In</a>
				</h1>
				<?php else : ?>
				<h1 class="header__section header__section--title">Settings
					<a href="" class="menu-trigger header__section--title__link">: Menu</a>
				</h1>
					<?php include_once(ROOT_PATH . "inc/page-nav.php"); ?>
				<?php endif; ?>
			<h2 class="header__section header__section--logo">
				<a href="<?= BASE_URL; ?>">connectd</a>
			</h2>
		</div>
	</header>
	<section>
		<div class="section-heading color-blue">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">
						<blockquote class="intro-quote text-center">
							Settings
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp4 unit-2-3--bp1 content-overlay">
				<?php if(empty($errors) === false) : ?>
					<p class="message message--error"><?= implode('</p><p>', $errors); ?></p>
				<?php endif; ?>
				<?php if ($status == "success") : ?>
				<p class="message message--success">Thank you for registering. Please check your emails to activate your account.</p>
				<?php endif; ?>
				<form method="post" action="<?= BASE_URL; ?>designers/signup.php" autocomplete="off" class="sign-up-form">
					<input type="text" name="firstname" placeholder="First name" class="field-1-2" value="<?php if (isset($firstname)) { echo htmlspecialchars($firstname); } ?>" autofocus>
					<input type="text" name="lastname" placeholder="Surname" class="field-1-2 float-right" value="<?php if (isset($lastname)) { echo htmlspecialchars($lastname); } ?>">
					<input type="email" name="email" placeholder="Email" value="<?php if (isset($email)) { echo htmlspecialchars($email); } ?>">
					<div class="button-container">
		            	<input class="submit" name="submit" type="submit" value='Update Settings'>
					</div>
		        </form>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "inc/footer.php"); ?>
