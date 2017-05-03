<?php

class ProfileVisitManager {
	protected $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function create(ProfileVisit $profile) {
		$q = $this->_db->prepare('
			INSERT INTO user_visit(id, idUser, idProfileVisited, time)
			VALUES(:id, :idUser, :idProfileVisited, :time)');
		$q->bindValue(':id', $profile->getId(), PDO::PARAM_INT);
		$q->bindValue(':idUser', $profile->getIdUser(), PDO::PARAM_INT);
		$q->bindValue(':idProfileVisited', $profile->getIdProfileVisited(), PDO::PARAM_INT);
		$q->bindValue(':time', time(), PDO::PARAM_INT);

		$q->execute();

		$profile->setId($this->_db->lastInsertId());
		return ($profile->getId());
	}

	public function get( $id ) {
		$q = $this->_db->prepare('SELECT * FROM user_visited WHERE id = :id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();

		$donnees = $q->fetch();

		if ($q->rowCount() > 0) {
			$profile = new ProfileLike($donnees['id']);
			$profile->hydrate($donnees);
			return ($profile);
		} else {
			return false;
		}
	}

	public function getListOfUserLikes($user) {
		$query = "SELECT * FROM user_visited WHERE idProfileVisited = :idProfileVisited";
		$q = $this->_db->prepare($query);
		$q->bindValue(':idProfileVisited', $user, PDO::PARAM_INT);
		$q->execute();

		$result = array();
		while($data = $q->fetch()) {
			$profile = new ProfileLike(0);
			$profile->hydrate($data);
			$result[] = $profile;
		}
		return ($result);
	}

	public function getNumberOfLikes($user) {
		$query = "SELECT COUNT(*) FROM user_visited WHERE idProfileVisited = :idProfileVisited";
		$q = $this->_db->prepare($query);
		$q->bindValue(':idProfileVisited', $user, PDO::PARAM_INT);
		$q->execute();

		$result = $q->fetch();
		return ($result[0]);
	}

	public function ifProfileIsLikedByUser($profileLiked, $byUser) {
		$query = "SELECT COUNT(*) FROM user_visited WHERE idProfileVisited = :idProfileVisited AND idUser = :idUser";
		$q = $this->_db->prepare($query);
		$q->bindValue(':idProfileVisited', $profileLiked, PDO::PARAM_INT);
		$q->bindValue(':idUser', $byUser, PDO::PARAM_INT);
		$q->execute();

		$result = $q->fetch();
		return ($result[0]);
	}

	public function delete( $id ) {		
		$q = $this->_db->prepare('DELETE FROM user_visited WHERE id = :id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();

		return true;
	}
	public function deleteWithoutId($profileLiked, $byUser) {		
		$q = $this->_db->prepare('DELETE FROM user_visited WHERE idProfileVisited = :idProfileVisited AND idUser = :idUser');
		$q->bindValue(':idProfileVisited', $profileLiked, PDO::PARAM_INT);
		$q->bindValue(':idUser', $byUser, PDO::PARAM_INT);
		$q->execute();

		return true;
	}
}