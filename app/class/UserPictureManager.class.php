<?php

class UserPictureManager {
	protected $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function add(UserPicture $userPicture) {
		$q = $this->_db->prepare('
			INSERT INTO userpictures(upload_source, filter_used, owner_id, upload_time)
			VALUES(:upload_source, :filter_used, :owner_id, :upload_time)');
		$q->bindValue(':upload_source', $userPicture->getUpload_source(), PDO::PARAM_STR);
		$q->bindValue(':filter_used', $userPicture->getFilter_used(), PDO::PARAM_INT);
		$q->bindValue(':owner_id', $userPicture->getOwner_id(), PDO::PARAM_INT);
		$q->bindValue(':upload_time', time(), PDO::PARAM_INT);

		$q->execute();

		$userPicture->setId($this->_db->lastInsertId());
		$userPicture->saveToFile();
		return ($userPicture->getId());
	}

	public function get( $id ) {
		$q = $this->_db->prepare('SELECT * FROM userpictures WHERE id = :id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();

		$donnees = $q->fetch();

		if ($q->rowCount() > 0) {
			$picture = new userPicture($donnees['id']);
			$picture->hydrate($donnees);
			return ($picture);
		} else {
			return false;
		}
	}

	public function getEditedPictures() {
		$q = $this->_db->prepare('
			SELECT * FROM userpictures WHERE filter_used != 0');
		$q->execute();

		$result = $q->fetchAll();
		return ($result);
	}
}