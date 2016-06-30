<?php

require_once("app/class/Token.class.php");

Class TokenManager {
	private $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function add(Token $token) {
		$q = $this->_db->prepare('
			INSERT INTO tokens(user_id, time_created, token, usefor)
			VALUES(:user_id, :time_created, :token, :usefor)');
		$q->bindValue(':user_id', $token->getUser_id(), PDO::PARAM_INT);
		$q->bindValue(':time_created', $token->getTime_created(), PDO::PARAM_STR);
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

	public function update(Token $token) {
		print_r($token);
		$q = $this->_db->prepare('
			UPDATE tokens
			SET user_id = :user_id, token = :token, time_created = :time_created, usefor = :usefor, isused = :isused
			WHERE id = :id');
		$q->bindValue(':id', $token->getId(), PDO::PARAM_INT);
		$q->bindValue(':user_id', $token->getUser_id(), PDO::PARAM_INT);
		$q->bindValue(':token', $token->getToken(), PDO::PARAM_STR);
		$q->bindValue(':time_created', $token->getTime_created(), PDO::PARAM_STR);
		$q->bindValue(':usefor', $token->getUsefor(), PDO::PARAM_STR);
		$q->bindValue(':isused', $token->isUsed(), PDO::PARAM_INT);

		$q->execute();
	}

	public function getFromToken($token) {
		return $this->get('token', $token);
	}
}