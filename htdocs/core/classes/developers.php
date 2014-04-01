<?php
	class Developers {
			
		// Properties
	 	
		private $db;

		// Methods
		
		public function __construct($database) {
		    $this->db = $database;
		}

		/**
		 * Restrict developers data to 6 most recent 
		 *
		 * @param  void
		 * @return array
		 */ 
		public function get_developers_recent() {

			$recent = "";
			$all = get_developers_all();

			$total_developers = count($all);
			$position = 0;
			$list_view = "";

			foreach ($all as $developer) {
				$position = $position + 1;
				// if designer is one of the 4 most recent designers
				if ($total_developers - $position < 6) {
					$recent[] = $developer;
				}
			}
			return $recent;
		}

		/**
		 * Get data for all developers in db
		 *
		 * @param  void
		 * @return array
		 */ 
		public function get_developers_all() {
			$results =  $this->db->prepare("
				SELECT u.user_id, u.firstname, u.lastname, f.freelancer_id, f.jobtitle, f.priceperhour, ut.*
				FROM ((" . DB_NAME . ".users AS u
				LEFT JOIN " . DB_NAME . ".freelancers AS f
				ON u.user_id = f.freelancer_id)
				LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON u.user_id = ut.user_type_id)
				WHERE u.confirmed = ?
				AND ut.user_type = ?
			");
			$results->bindValue(1, 1);
			$results->bindValue(2, 'developer');
			
			try {
				$results->execute();
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}
			
			$developers = $results->fetchAll(PDO::FETCH_ASSOC);

			return $developers;

		}

		/**
		 * Get data for a single designer
		 *
		 * @param  int $id 
		 * @return array
		 */ 
		public function get_developers_single($id) {

			$results = $this->db->prepare("
				SELECT u.user_id, u.firstname, u.lastname, u.email, u.bio, u.portfolio, u.location, u.time_joined, f.freelancer_id, f.jobtitle, f.priceperhour, ut.*
				FROM ((" . DB_NAME . ".users AS u
				LEFT JOIN " . DB_NAME . ".freelancers AS f
				ON u.user_id = f.freelancer_id)
				LEFT JOIN " . DB_NAME . ".user_types AS ut
				ON u.user_id = ut.user_type_id)
				WHERE u.confirmed = ?
				AND u.user_id = ?
				AND ut.user_type = ?
			");
			$results->bindValue(1, 1);
			$results->bindValue(2, $id);
			$results->bindValue(3, 'developer');

			try {
				$results->execute();
			}catch(PDOException $e) {
				$general = new General($db);
				$general->errorView($general, $e);
			}

			$developers = $results->fetch(PDO::FETCH_ASSOC);
			
			return $developers;
		}
	}