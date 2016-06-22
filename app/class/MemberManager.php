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

	public function get($id) {
		$q = $this->_db->prepare('SELECT * FROM users WHERE id=:value');
		$q->bindValue(':value', $id, PDO::PARAM_INT);
		$q->execute();
		if ($q->rowCount() > 0) {
			$member = new Member($id);
			$member->hydrate($q->fetch());
			return ($member);
		} else {
			return false;
		}
	}

	public function getFromNickname( $nickname ) {
		$q = $this->_db->prepare('SELECT id FROM users WHERE nickname=:value');
		$q->bindValue(':value', $nickname, PDO::PARAM_STR);
		$q->execute();

		if ($q->rowCount() > 0) {
			$data = $q->fetch();
			$member = $this->get($data['id']);
			return $member;
		} else {
			return false;
		}
	}

	public function ifExist($field, $value) {
		$q = $this->_db->prepare('SELECT COUNT(*) FROM users WHERE :field = :value');
		$q->bindValue(':field', $field, PDO::PARAM_STR);
		$q->bindValue(':value', $value, PDO::PARAM_STR);
		$q->execute();

		$result = $q->fetch();
		if ($result > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function isPasswordCorrect($memberID, $passToCheck) {
		$member = $this->get($memberID);
		if (is_object($member)) {
			if ($member->getPassword() == hash("whirlpool", $passToCheck)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}