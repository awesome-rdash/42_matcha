<?php

class LikeManager {
	protected $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function add(Like $like) {
		$q = $this->_db->prepare('
			INSERT INTO likes(id, id_user, id_picture, tine_liked)
			VALUES(:id, :id_user, :id_picture, :time_liked)');
		$q->bindValue(':id', $comment->getId(), PDO::PARAM_INT);
		$q->bindValue(':id_user', $comment->getId_user(), PDO::PARAM_INT);
		$q->bindValue(':id_picture', $comment->getId_picture(), PDO::PARAM_INT);
		$q->bindValue(':time_liked', time(), PDO::PARAM_INT);

		$q->execute();

		$like->setId($this->_db->lastInsertId());
		return ($comment->getId());
	}

	public function get( $id ) {
		$q = $this->_db->prepare('SELECT * FROM likes WHERE id = :id');
		$q->bindValue(':id', $value, PDO::PARAM_INT);
		$q->execute();

		$donnees = $q->fetch();

		if ($q->rowCount() > 0) {
			$like = new Like($donnees['id']);
			$like->hydrate($donnees);
			return ($like);
		} else {
			return false;
		}
	}

	public function getCountFromPicture( $pictureId ) {
		$q = $this->_db->prepare('
			SELECT count(*) FROM likes WHERE id_picture = :id_picture');
		$q->bindValue(':id_picture', $pictureId, PDO::PARAM_INT);
		$q->execute();

		$result = $q->fetchColumn();
		return ($result);
	}
}