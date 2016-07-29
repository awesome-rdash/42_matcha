<?php

class CommentManager {
	protected $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function add(Comment $comment) {
		$q = $this->_db->prepare('
			INSERT INTO comments(id, id_user, id_picture, content, time_posted)
			VALUES(:id, :id_user, :id_picture, :content, :time_posted)');
		$q->bindValue(':id', $comment->getId(), PDO::PARAM_INT);
		$q->bindValue(':id_user', $comment->getId_user(), PDO::PARAM_INT);
		$q->bindValue(':id_picture', $comment->getId_picture(), PDO::PARAM_INT);
		$q->bindValue(':content', $comment->getContent(), PDO::PARAM_STR);
		$q->bindValue(':time_posted', time(), PDO::PARAM_INT);

		$q->execute();

		$comment->setId($this->_db->lastInsertId());
		return ($comment->getId());
	}

	public function get( $id ) {
		$q = $this->_db->prepare('SELECT * FROM comments WHERE id = :id');
		$q->bindValue(':id', $value, PDO::PARAM_INT);
		$q->execute();

		$donnees = $q->fetch();

		if ($q->rowCount() > 0) {
			$comment = new Comment($donnees['id']);
			$comment->hydrate($donnees);
			return ($comment);
		} else {
			return false;
		}
	}

	public function getFromPicture( $pictureId ) {
		$q = $this->_db->prepare('
			SELECT * FROM comments WHERE id_picture = :id_picture');
		$q->bindValue(':id_picture', $pictureId, PDO::PARAM_INT);
		$q->execute();

		$result = $q->fetchAll();
		return ($result);
	}
}