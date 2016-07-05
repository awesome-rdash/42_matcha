<?php

class UserPictureManager {
	protected $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function add(UserPicture $userPicture) {
		$q = $this->_db->prepare('
			INSERT INTO userpictures(upload_source, filter_used, owner_id)
			VALUES(:upload_source, :filter_used, :owner_id)');
		$q->bindValue(':upload_source', $member->getNickname(), PDO::PARAM_STR);
		$q->bindValue(':filter_used', $member->getPassword(), PDO::PARAM_INT);
		$q->bindValue(':owner_id', $member->getBirthdate(), PDO::PARAM_INT);

		$q->execute();

		$id = $this->_db->lastInsertId();
		return ($id);
	}
}