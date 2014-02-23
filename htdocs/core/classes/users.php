<?php
	class Users {
	 
		private $db;

		public function __construct($database) {
		    $this->db = $database;
		}
	  
		// Test if email already exists in database
		public function email_exists($email) {
		 
			$query = $this->db->prepare("SELECT designers.email 
						FROM " . DB_NAME . ".designers 
						WHERE designers.email = ? 
						UNION SELECT developers.email 
						FROM " . DB_NAME . ".developers 
						WHERE developers.email = ?
						UNION SELECT employers.email 
						FROM " . DB_NAME . ".employers 
						WHERE employers.email = ?");
			$query->bindParam(1, $email);
			$query->bindParam(2, $email);
			$query->bindParam(3, $email);

			try{
		 
				$query->execute();
				$rows = $query->rowCount();
		 
				if($rows > 0){
					return true;
				}else{
					return false;
				}
		 
			} catch (PDOException $e){
				die($e->getMessage());
			}
		 
		}

		// Test if user has confirmed their email
		public function email_confirmed($email) {
 
			$query = $this->db->prepare("SELECT COUNT(*) FROM (
				(SELECT 1 FROM " . DB_NAME . ".developers AS a WHERE a.email = ? AND a.confirmed = ?)
				UNION ALL 
				(SELECT 1 FROM " . DB_NAME . ".designers AS b WHERE b.email = ? AND b.confirmed = ?) 
				UNION ALL
				(SELECT 1 FROM " . DB_NAME . ".employers AS c WHERE c.email = ? AND c.confirmed = ?)) z
			");

			$query->bindValue(1, $email);
			$query->bindValue(2, 1);
			$query->bindValue(3, $email);
			$query->bindValue(4, 1);
			$query->bindValue(5, $email);
			$query->bindValue(6, 1);
			
			try{
				
				$query->execute();
				$rows = $query->fetchColumn();
		 
				if($rows == 1){
					return true;
				}else{
					return false;
				}
		 
			} catch(PDOException $e){
				die($e->getMessage());
			}
		}

		public function login($email, $password) {
 
			$query = $this->db->prepare("SELECT 
				designers.id, designers.email, designers.password 
				FROM " . DB_NAME . ".designers 
				WHERE designers.email = ? 
				UNION SELECT developers.id, developers.email, developers.password 
				FROM " . DB_NAME . ".developers WHERE developers.email = ? 
				UNION SELECT employers.id, employers.email, employers.password 
				FROM " . DB_NAME . ".employers WHERE employers.email = ?");
			$query->bindValue(1, $email);
			$query->bindValue(2, $email);
			$query->bindValue(3, $email);
			
			try{
				
				$query->execute();
				$data 				= $query->fetch();
				$stored_password 	= $data['password'];
				$id 				= $data['id'];
				
				#hashing the supplied password and comparing it with the stored hashed password.
				if($stored_password === sha1($password)){
					return $id;	
				}else{
					return false;	
				}
		 
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}

		// Get user data
		public function userdata($id) {
 
			$query = $this->db->prepare("
				SELECT firstname, lastname FROM " . DB_NAME . ".developers WHERE `id`= ?
				UNION SELECT firstname, lastname FROM " . DB_NAME . ".designers WHERE `id`= ?
				UNION SELECT firstname, lastname FROM " . DB_NAME . ".employers WHERE `id`= ?
				");
			$query->bindValue(1, $id);
			$query->bindValue(2, $id);
			$query->bindValue(3, $id);
		 
			try{
		 
				$query->execute();
		 
				return $query->fetch();
		 
			} catch(PDOException $e){
		 
				die($e->getMessage());
			}
		}

	}