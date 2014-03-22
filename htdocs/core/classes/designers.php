<?php
	class Designers{
		
		// Properties
	 	
		private $db;

		// Methods
		
		public function __construct($database) {
		    $this->db = $database;
		}

		public function get_designers_recent() {

			$recent = "";
			$all = get_designers_all();

			$total_designers = count($all);
			$position = 0;
			$list_view = "";

			foreach ($all as $designer) {
				$position = $position + 1;
				// if designer is one of the 4 most recent designers
				if ($total_designers - $position < 6) {
					$recent[] = $designer;
				}
			}
			return $recent;
		}

		public function get_designers_all() {

			$results = $this->db->prepare("
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
			$results->bindValue(2, 'designer');

			try {
				$results->execute();
			} catch (Exception $e) {
				echo "Damn. All designer data could not be retrieved.";
				exit;
			}
			
			$designers = $results->fetchAll(PDO::FETCH_ASSOC);

			return $designers;

		}

		public function get_designers_single($id) {

			$results = $this->db->prepare("
				SELECT u.user_id, u.firstname, u.lastname, u.bio, u.portfolio, u.location, f.freelancer_id, f.jobtitle, f.priceperhour, ut.*
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
			$results->bindValue(3, 'designer');

			try {
				$results->execute();
			} catch (Exception $e) {
				echo "Damn. Single designer data could not be retrieved.";
				exit;
			}

			$designers= $results->fetch(PDO::FETCH_ASSOC);
			
			return $designers;
		}
	}