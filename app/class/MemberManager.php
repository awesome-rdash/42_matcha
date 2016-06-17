<?php

require_once("app/class/Member.class.php");

class MemberManager {
	private $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function add(Membre $membre) {
		$q = $this->_db->prepare('
			INSERT INTO user_list(nickname, email, password, birthdate, firstname, lastname)
			VALUES(:nickname, :email, :password, :birthdate, :firstname, :lastname)');
		$q->bindValue(':nickname', $membre->getLogin(), PDO::PARAM_STR);
		$q->bindValue(':email', $membre->getEmail(), PDO::PARAM_STR);
		$q->bindValue(':password', $membre->getPassword(), PDO::PARAM_STR);
		$q->bindValue(':birthdate', $membre->getBirthdate());
		$q->bindValue(':firstname', $membre->getPassword(), PDO::PARAM_STR);
		$q->bindValue(':lastname', $membre->getPassword(), PDO::PARAM_STR);

		$q->execute();

		$id = $this->_db->lastInsertId();
		return ($id);
	}
}