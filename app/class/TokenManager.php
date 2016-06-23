<?php

require_once("app/class/Token.class.php");

Class TokenManager {
	private $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function add(Token $token) {
		$q = $this->_db->prepare('
			INSERT INTO tokens(user_id, token, usefor)
			VALUES(:user_id, :token, :usefor)');
		$q->bindValue(':user_id', $token->getUser_id(), PDO::PARAM_INT);
		$q->bindValue(':token', $token->getToken(), PDO::PARAM_STR);
		$q->bindValue(':usefor', $token->getUsefor(), PDO::PARAM_STR);

		$q->execute();
		$id = $this->_db->lastInsertId();
		return ($id);
	}
}