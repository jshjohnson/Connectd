<?php
	class Sessions {
	
		// Properties
	 	
		private $db;

		// Methods
		
		public function __construct($database) {
		    $this->db = $database;
		}
	}