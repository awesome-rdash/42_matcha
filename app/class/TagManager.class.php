<?php

require_once("app/class/Tags.class.php");

class tagsManager {
	private $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function add(Tag $tag) {
		$q = $this->_db->prepare('
			INSERT INTO tags(content)
			VALUES(:content)');
		$q->bindValue(':content', $tag->getContent(), PDO::PARAM_STR);

		$q->execute();

		$id = $this->_db->lastInsertId();
		return ($id);
	}

	public function get( $field, $value ) {
		$fieldCorrectValues = array("id", "content");
		if (!in_array($field, $fieldCorrectValues)) {
			throw new Exception("Invalid field");
		}
		$statement = ('SELECT * FROM tags WHERE ' . $field . ' = :value');
		$q = $this->_db->prepare($statement);
		$q->bindValue(':value', $value, PDO::PARAM_STR);
		$q->execute();
		$donnees = $q->fetch();

		if ($q->rowCount() > 0) {
			$tag = new Tag($donnees['id']);
			$tag->hydrate($donnees);

			return ($tag);
		} else {
			return false;
		}
	}

	public function getFromId($id) {
		return $this->get('id', $id);
	}

	public function getAllExistingTags() {
		$q = $this->_db->prepare('
			SELECT * FROM tags');
		$q->execute();

		$result = $q->fetchAll();
		return ($result);
	}
}