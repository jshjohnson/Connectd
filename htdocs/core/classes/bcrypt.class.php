<?php
	class Bcrypt {
		
		// Based upon http://www.sunnytuts.com/article/login-and-registration-with-object-oriented-php-and-pdo-part-2
	 	
		private $rounds;

		// Methods

		public function __construct($rounds = 12) {
			if(CRYPT_BLOWFISH != 1) {
				throw new Exception("Bcrypt is not supported on this server, please see the following to learn more: http://php.net/crypt");
			}
			$this->rounds = $rounds;
		}
	 
		/**
		 * Salt the hashed password 
		 *
		 * @param  void
		 * @return string
		 */ 
		private function genSalt() {
	 
			$string = str_shuffle(mt_rand());// generating a random string
			$salt 	= uniqid($string ,true);// generating a random and unique string
	 
			/* Return */
			return $salt;
		}
	  
		/**
		 * Generate a hashed password on sign up
		 *
		 * @param  string $password
		 * @return string
		 */ 
		public function genHash($password) {
			/* 2y selects bcrypt algorithm */
			/* $this->rounds is the workload factor, which is kept usually from 12 to 15 */
	 
			$hash = crypt($password, '$2y$' . $this->rounds . '$' . $this->genSalt());
			/* Return */
			return $hash;
		}
		
		/**
		 * Verify password by matching hashes
		 *
		 * @param  string $password
		 * @param  string $existingHash
		 * @return boolean
		 */ 
		public function verify($password, $existingHash) {
			/* Hash new password with old hash */
			$hash = crypt($password, $existingHash);
			
			/* Do Hashs match? */
			if($hash === $existingHash) {
				return true;
			} else {
				return false;
			}
		}
	}