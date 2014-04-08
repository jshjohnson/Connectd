<?php 
	class Errors {

	 	/**
		 * Show PHP errors
		 *
		 * @param  void
		 * @return void
		 */ 
		public function showErrors() {
			error_reporting(E_ERROR|E_WARNING);
			ini_set('display_errors', 1);
		}

		/**
		 * Show PHP errors
		 *
		 * @param  void
		 * @return void
		 */ 
		public function errorView($users, $general, $e) {
			$pageTitle = 'Error';
			$pageType = 'Page';
			$section = 'Blue';
			include(ROOT_PATH . 'includes/header.inc.php');
			include(ROOT_PATH . 'views/error/error.html');
			include(ROOT_PATH . 'includes/footer.inc.php');
			exit();
		}
		
	}