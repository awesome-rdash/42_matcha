<?php

require_once("app/class/Member.class.php");

class MemberManager {
	private $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function add(Member $membre) {
		$q = $this->_db->prepare('
			INSERT INTO users(nickname, email, password, birthdate, firstname, lastname)
			VALUES(:nickname, :email, :password, :birthdate, :firstname, :lastname)');
		$q->bindValue(':nickname', $membre->getNickname(), PDO::PARAM_STR);
		$q->bindValue(':email', $membre->getEmail(), PDO::PARAM_STR);
		$q->bindValue(':password', $membre->getPassword(), PDO::PARAM_STR);
		$q->bindValue(':birthdate', $membre->getBirthdate());
		$q->bindValue(':firstname', $membre->getFirstname(), PDO::PARAM_STR);
		$q->bindValue(':lastname', $membre->getLastname(), PDO::PARAM_STR);

		$q->execute();

		$id = $this->_db->lastInsertId();
		return ($id);
	}

	public function getFrom( $field, $value ) {
		$q = $this->_db->prepare('SELECT * FROM users WHERE :field = :value');
		if ($field == "id") {
			$q->bindValue(':field', $id, PDO::PARAM_INT);
		} else if ($field == "nickname" || $field == "email") {
			$q->bindValue(':field', $id, PDO::PARAM_STR);
		} else {
			return genError("users", "badselector", "get");
		}

		$q->execute();

		if ($q->rowCount() > 0) {
			$member = new Member($id);
			$member->hydrate($q->fetch());
			return ($member);
		} else {
			return genError("users", "notfound", "get");
		}
	}

	public function ifExist($field, $value) {
		$q = $this->_db->prepare('SELECT COUNT(:field) FROM users WHERE value = :value');
		$q->bindValue(':field', $field, PDO::PARAM_STR);
		$q->bindValue(':value', $field, PDO::PARAM_STR);
		$q->execute();

		$result = $q->fetch();
		if ($result > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function isPasswordCorrect($memberID, $passToCheck) {
		if ($this->ifExist("id", $memberID)) {
			$q = $this->_db->prepare('SELECT password FROM users WHERE id = :id');
			$q->bindValue(':id', $passToCheck, PDO::PARAM_INT);
			$q->execute();

			if ($this->_password == $hash("whirlpool", $passToCheck)) {
				return true;
			} else {
				return false;
			}
		} else {
			
		}
	}
}