<?php 	
	require_once("../config/config.php"); 
	include_once(ROOT_PATH . "inc/functions.php");

	$pageTitle = "Settings";
	$section = "Settings";
	
	checkLoggedOut();
	
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
	include_once(ROOT_PATH . "views/header.php");
	include_once(ROOT_PATH . "views/page-header.php");
?>  
		<section class="container footer--push">
			<div class="grid--no-marg cf">
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad">
					<header class="header--panel header--developer cf">
						<h3 class="float-left">Change Password</h3>
					</header>
				</article>
				<article class="dashboard-panel grid__cell module-1-2 module--no-pad float-right">
					<header class="header--panel header--developer cf">
						<h3 class="float-left">Delete Account</h3>
					</header>
				</article>
			</div>
		</section>
<?php 
	include_once(ROOT_PATH . "views/footer.php"); 
?>
