<?php
	class Jobs {
		
		// Properties
	 	
		private $db;

		// Methods
		
		public function __construct($database) {
		    $this->db = $database;
		}
	}