<?php

class ProfileLikeManager {
	protected $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function new(ProfileLike $profile) {
		$q = $this->_db->prepare('
			INSERT INTO user_likes(id, idUser, idProfileLiked, time)
			VALUES(:id, :idUser, :idProfileLiked, :time)');
		$q->bindValue(':id', $profile->getId(), PDO::PARAM_INT);
		$q->bindValue(':idUser', $profile->getIdUser(), PDO::PARAM_INT);
		$q->bindValue(':idProfileLiked', $profile->getIdProfileLiked(), PDO::PARAM_INT);
		$q->bindValue(':time', time(), PDO::PARAM_INT);

		$q->execute();

		$profile->setId($this->_db->lastInsertId());
		return ($profile->getId());
	}

	public function get( $id ) {
		$q = $this->_db->prepare('SELECT * FROM user_likes WHERE id = :id');
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
		$query = "SELECT * FROM user_likes WHERE idProfileLiked = :idProfileLiked";
		$q = $this->_db->prepare($query);
		$q->bindValue(':idProfileLiked', $user, PDO::PARAM_INT);
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
		$query = "SELECT COUNT(*) FROM user_likes WHERE idProfileLiked = :idProfileLiked";
		$q = $this->_db->prepare($query);
		$q->bindValue(':idProfileLiked', $user, PDO::PARAM_INT);
		$q->execute();

		$result = $q->fetch();
		return ($result[0]);
	}

	public function ifProfileIsLikedByUser($profileLiked, $byUser) {
		$query = "SELECT COUNT(*) FROM user_likes WHERE idProfileLiked = :idProfileLiked AND idUser = :idUser";
		$q = $this->_db->prepare($query);
		$q->bindValue(':idProfileLiked', $profileLiked, PDO::PARAM_INT);
		$q->bindValue(':idUser', $byUser, PDO::PARAM_INT);
		$q->execute();

		$result = $q->fetch();
		return ($result[0]);
	}

	public function delete( $id ) {		
		$q = $this->_db->prepare('DELETE FROM idProfileLiked WHERE id = :id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();

		return true;
	}
}