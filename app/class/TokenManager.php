<?php

require_once("app/class/Token.class.php");

Class TokenManager {
	private $_db;

	public function __construct($db) {
		$this->_db = $db;
	}
}