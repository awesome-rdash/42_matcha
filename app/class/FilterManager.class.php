<?php

class FilterManager {
	protected $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function add(Filter $filter) {
		$q = $this->_db->prepare('
			INSERT INTO userpictures(owner_id, upload_time)
			VALUES(:owner_id, :upload_time)');
		$q->bindValue(':owner_id', $filter->getOwner_id(), PDO::PARAM_INT);
		$q->bindValue(':upload_time', time(), PDO::PARAM_INT);

		$q->execute();

		$filter->setId($this->_db->lastInsertId());
		$filter->saveToFile();
		return ($filter->getId());
	}

	public function get( $id ) {
		$q = $this->_db->prepare('SELECT * FROM filters WHERE id = :id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();

		$donnees = $q->fetch();

		if ($q->rowCount() > 0) {
			$filter = new Filter($donnees['id']);
			$filter->hydrate($donnees);
			return ($filter);
		} else {
			return false;
		}
	}

	public function getList() {
		$q = $this->_db->prepare('
			SELECT * FROM filters');
		$q->execute();

		$result = $q->fetchAll();
		return ($result);
	}

	public function delete( $id ) {		
		$q = $this->_db->prepare('DELETE FROM filters WHERE id = :id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();

		return true;
	}
}