<?php

require_once("app/class/Member.class.php");

class MemberManager {
	private $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function add(Member $member) {
		$q = $this->_db->prepare('
			INSERT INTO users(nickname, email, password, register_time, firstname, lastname)
			VALUES(:nickname, :email, :password, :register_time, :firstname, :lastname)');
		$q->bindValue(':nickname', $member->getNickname(), PDO::PARAM_STR);
		$q->bindValue(':email', $member->getEmail(), PDO::PARAM_STR);
		$q->bindValue(':password', $member->getPassword(), PDO::PARAM_STR);
		$q->bindValue(':register_time', $member->getRegister_time(), PDO::PARAM_INT);
		$q->bindValue(':firstname', $member->getFirstname(), PDO::PARAM_STR);
		$q->bindValue(':lastname', $member->getLastname(), PDO::PARAM_STR);

		$q->execute();

		$id = $this->_db->lastInsertId();
		return ($id);
	}

	public function get( $field, $value ) {
		$fieldCorrectValues = array("id", "nickname", "email");
		if (!in_array($field, $fieldCorrectValues)) {
			throw new Exception("Invalid field");
		}
		$statement = ('SELECT * FROM users WHERE ' . $field . ' = :value');
		$q = $this->_db->prepare($statement);
		$q->bindValue(':value', $value, PDO::PARAM_STR);
		$q->execute();
		$donnees = $q->fetch();

		if ($q->rowCount() > 0) {
			$member = new Member($donnees['id']);
			$member->hydrate($donnees);

			return ($member);
		} else {
			return false;
		}
	}

	public function getFromId($id) {
		return $this->get('id', $id);
	}

	public function update(Member $member) {
		$q = $this->_db->prepare('
			UPDATE users
			SET nickname = :nickname, email = :email, password = :password, register_time = :register_time, birthdate = :birthdate, lastname = :lastname, firstname  = :firstname, phone = :phone, sexe = :sexe, bio = :bio, mail_confirmed = :mail_confirmed, sexual_orientation = :sexual_orientation, featuredPictures = :featuredPictures
			WHERE id = :id');
		$q->bindValue(':id', $member->getId(), PDO::PARAM_INT);
		$q->bindValue(':nickname', $member->getNickname(), PDO::PARAM_STR);
		$q->bindValue(':email', $member->getEmail(), PDO::PARAM_STR);
		$q->bindValue(':password', $member->getPassword(), PDO::PARAM_STR);
		$q->bindValue(':register_time', $member->getRegister_time(), PDO::PARAM_STR);
		$q->bindValue(':birthdate', $member->getBirthdate(), PDO::PARAM_STR);
		$q->bindValue(':lastname', $member->getLastname(), PDO::PARAM_STR);
		$q->bindValue(':firstname', $member->getFirstname(), PDO::PARAM_STR);
		$q->bindValue(':phone', $member->getPhone(), PDO::PARAM_STR);
		$q->bindValue(':sexe', $member->getSexe(), PDO::PARAM_INT);
		$q->bindValue(':bio', $member->getBio(), PDO::PARAM_STR);
		$q->bindValue(':mail_confirmed', $member->getMail_confirmed(), PDO::PARAM_INT);
		$q->bindValue(':sexual_orientation', $member->getSexual_orientation(), PDO::PARAM_STR);
		$q->bindValue(':featuredPictures', $member->getFeaturedPictures(), PDO::PARAM_STR);

		$q->execute();
	}

	public function ifExist($field, $value) {
		$fieldCorrectValues = array("id", "nickname", "email");
		if (!in_array($field, $fieldCorrectValues)) {
			throw new Exception("Invalid field");
		}

		$statement = 'SELECT COUNT(*) FROM users WHERE ' . $field . ' = :value';
		$q = $this->_db->prepare($statement);
		$q->bindValue(':value', $value, PDO::PARAM_STR);
		$q->execute();

		$result = $q->fetch();
		if ($result[0] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getAllExistingUsers() {
		$q = $this->_db->prepare('
			SELECT * FROM users');
		$q->execute();

		$result = $q->fetchAll();
		return ($result);
	}

	public function isPasswordCorrect($memberID, $passToCheck) {
		$member = $this->get('id', $memberID);
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