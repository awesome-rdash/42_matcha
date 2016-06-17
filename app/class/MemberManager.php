<?php

require_once("app/class/Member.class.php");

class MemberManager {
	private $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function add(Membre $membre) {
		$q = $this->_db->prepare('
			INSERT INTO users(nickname, email, password, birthdate, firstname, lastname)
			VALUES(:nickname, :email, :password, :birthdate, :firstname, :lastname)');
		$q->bindValue(':nickname', $membre->getLogin(), PDO::PARAM_STR);
		$q->bindValue(':email', $membre->getEmail(), PDO::PARAM_STR);
		$q->bindValue(':password', $membre->getPassword(), PDO::PARAM_STR);
		$q->bindValue(':birthdate', $membre->getBirthdate());
		$q->bindValue(':firstname', $membre->getFirstname(), PDO::PARAM_STR);
		$q->bindValue(':lastname', $membre->getLastname(), PDO::PARAM_STR);

		$q->execute();

		$id = $this->_db->lastInsertId();
		return ($id);
	}

	public function ifExist($field, $value) {
		$q = $this->_db->prepare('SELECT COUNT(:field) FROM users WHERE value = :value');
		$q->bindValue(':field', $field, PDO::PARAM_STR);
		$q->bindValue(':value', $field, PDO::PARAM_STR);
		$q->execute();

		$result = $q->fetch();
		echo "AWESOME: $result\n";
	}

	public function newMemberFromRegistration( $kwargs ) {
		$toCheck = array("nickname", "email", "password", "password2", "birthdate");

		foreach($toCheck as $element) {
			if (!isset($kwargs[$element]) || empty($kwargs[$element])) {
				$error = genError("register", "missingfield", $element);
				return $error;
			}
		}

		$kwargs['password'] = hash("whirlpool", $kwargs['password']);
		$kwargs['password2'] = hash("whirlpool", $kwargs['password2']);
		if ($kwargs['password'] !== $kwargs['password2']) {
			$error = array("element" => "password",
				"type" => "notthesame");
			return $error;
		}

		$toCheck = array("nickname", "email");
		foreach($toCheck as $element) {
			if ($this->ifExist($element, $kwargs[$element])) {
				$error = array("element" => $element,
				"type" => "alreadyexist");
				return $error;
			}
		}
	}
}