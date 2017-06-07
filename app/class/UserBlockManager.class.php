<?php

class UserBlockManager {
	protected $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function create(UserBlock $block) {
		$q = $this->_db->prepare('
			INSERT INTO blocked_users(id, fromUser, toUserBlocked, time)
			VALUES(:id, :fromUser, :toUserBlocked, :time)');
		$q->bindValue(':id', $block->getId(), PDO::PARAM_INT);
		$q->bindValue(':fromUser', $block->getFromUser(), PDO::PARAM_INT);
		$q->bindValue(':toUserBlocked', $block->getToUserBlocked(), PDO::PARAM_INT);
		$q->bindValue(':time', time(), PDO::PARAM_INT);

		$q->execute();

		$block->setId($this->_db->lastInsertId());
		return ($block->getId());
	}

	public function ifProfileIsAlreadyBlockedByUser($profileBlocked, $byUser) {
		$query = "SELECT COUNT(*) FROM blocked_users WHERE toUserBlocked = :toUserBlocked AND fromUser = :fromUser";
		$q = $this->_db->prepare($query);
		$q->bindValue(':toUserBlocked', $profileBlocked, PDO::PARAM_INT);
		$q->bindValue(':fromUser', $byUser, PDO::PARAM_INT);
		$q->execute();

		$result = $q->fetch();
		return ($result[0]);
	}
}