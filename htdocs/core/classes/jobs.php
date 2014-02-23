<?php
	class Jobs {

		private $db;

		public function __construct($database) {
		    $this->db = $database;
		}
	}