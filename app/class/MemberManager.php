<?php

require_once("app/class/Membre.class.php");

class MemberManager {
	private $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function add(Membre $membre) {
		$q = $this->_db->prepare('
			INSERT INTO user_list(login, email, password, birthdate)
			VALUES(:login, :email, :password, "birthdate)');
		$q->bindValue(':login', $membre->getLogin(), PDO::PARAM_STR);
		$q->bindValue(':email', $membre->getEmail(), PDO::PARAM_STR);
		$q->bindValue(':password', $membre->getPassword(), PDO::PARAM_STR);
		$q->bindValue(':birthdate', $membre->getBirthdate());

		$q->execute();

		$id = $this->_db->lastInsertId();
		return ($id);
	}
}