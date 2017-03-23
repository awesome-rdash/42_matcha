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
			$picture = new UserPicture($donnees['id']);
			$picture->hydrate($donnees);
			return ($picture);
		} else {
			return false;
		}
	}

	public function ifExist($id) {
		$statement = 'SELECT COUNT(*) FROM users WHERE id = :id';
		$q = $this->_db->prepare($statement);
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->bindValue(':value', $value, PDO::PARAM_STR);
		$q->execute();

		$result = $q->fetch();
		if ($result[0] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getAllEditedPictures() {
		$q = $this->_db->prepare('
			SELECT * FROM userpictures WHERE filter_used != 0');
		$q->execute();

		$result = $q->fetchAll();
		return ($result);
	}

	public function getEditedPicturesFromUser( $user_id ) {
		$q = $this->_db->prepare('
			SELECT * FROM userpictures WHERE filter_used != 0 AND owner_id = :owner_id ORDER BY upload_time DESC');
		$q->bindValue(':owner_id', $user_id, PDO::PARAM_INT);
		$q->execute();

		$result = $q->fetchAll();
		return ($result);
	}

	public function getEditedPictures($user_id, $pics_ppage, $order, $startAt) {
		$uid = "";
		if ($user_id != 0) {
			$uid = "AND owner_id = $user_id";
		}

		$query = "SELECT * FROM userpictures WHERE filter_used != 0 $uid ORDER BY upload_time $order LIMIT $pics_ppage OFFSET $startAt";
		$q = $this->_db->prepare($query);
		$q->execute();

		$result = $q->fetchAll();
		return ($result);
	}

	public function getEditedPicturesCount($user_id, $pics_ppage) {
		$uid = "";
		if ($user_id != 0) {
			$uid = "AND owner_id = $user_id";
		}

		$query = "SELECT COUNT(*) FROM userpictures WHERE filter_used != 0 $uid";
		$q = $this->_db->prepare($query);
		$q->execute();

		$result = $q->fetch();
		return ($result);
	}

	public function delete( $id ) {		
		$q = $this->_db->prepare('DELETE FROM userpictures WHERE id = :id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();

		return true;
	}
}