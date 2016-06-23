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

	public function get( $field, $value ) {
		$fieldCorrectValues = array("id", "token");
		if (!in_array($field, $fieldCorrectValues)) {
			throw new Exception("Invalid field");
		}
		$statement = ('SELECT * FROM tokens WHERE ' . $field . ' = :value');
		$q = $this->_db->prepare($statement);
		$q->bindValue(':value', $value, PDO::PARAM_STR);
		$q->execute();

		$donnees = $q->fetch();

		if ($q->rowCount() > 0) {
			$token = new Token($donnees['id']);
			$token->hydrate($donnees);
			return ($token);
		} else {
			return false;
		}
	}

	public function getFromToken($token) {
		return $this->get('token', $token);
	}
}