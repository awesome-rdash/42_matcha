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
		$q->bindValue(':upload_source', $userPicture->getUpload_source(), PDO::PARAM_STR);
		$q->bindValue(':filter_used', $userPicture->getFilter_used(), PDO::PARAM_INT);
		$q->bindValue(':owner_id', $userPicture->getOwner_id(), PDO::PARAM_INT);

		$q->execute();

		$userPicture->setId($this->_db->lastInsertId());
		$userPicture->saveToFile();
		return ($userPicture->getId());
	}

	public function get($id) {

	}

	public function getEditedPictures() {
		$q = $this->_db->prepare('
			SELECT id FROM userpictures WHERE filter_used != 0');
		$q->execute();

		$result = $q->fetchAll();
		return ($result);
	}
}