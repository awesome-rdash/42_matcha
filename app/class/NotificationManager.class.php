<?php

class NotificationManager {
	protected $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function new(Notification $notification) {
		$q = $this->_db->prepare('
			INSERT INTO notifications(id, timestamp, type, new, user, fromUser)
			VALUES(:id, :timestamp, :type, :new, :toUser, :fromUser)');
		$q->bindValue(':id', $notification->getId(), PDO::PARAM_STR);
		$q->bindValue(':timestamp', $notification->getTimestamp(), PDO::PARAM_INT);
		$q->bindValue(':type', $notification->getType(), PDO::PARAM_STR);
		$q->bindValue(':new', $notification->hasBeenRead(), PDO::PARAM_INT);
		$q->bindValue(':fromUser', $notification->getTransmitter(), PDO::PARAM_INT);
		$q->bindValue(':toUser', $notification->getRecipient(), PDO::PARAM_INT);

		$q->execute();

		$notification->setId($this->_db->lastInsertId());
		return ($notification->getId());
	}

	public function get( $id ) {
		$q = $this->_db->prepare('SELECT * FROM notifications WHERE id = :id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();

		$donnees = $q->fetch();

		if ($q->rowCount() > 0) {
			$notification = new Notification($donnees['id']);
			$notification->hydrate($donnees);
			return ($notification);
		} else {
			return false;
		}
	}

	public function getUnreadNotificationsToUser($toUser) {
		$query = "SELECT * FROM notifications WHERE new = 1 AND toUser = :toUser";
		$q = $this->_db->prepare($query);
		$q->bindValue(':toUser', $toUser, PDO::PARAM_INT);
		$q->execute();

		$result = array();
		while($data = $q->fetch()) {
			$notification = new Notification(0);
			$notification->hydrate($data);
			$result[] = $notification;
		}
		return ($result);
	}

	public function getUnreadNotificationsCount($toUser) {
		$query = "SELECT COUNT(*) FROM notifications WHERE new = 1 AND toUser = :toUser";
		$q = $this->_db->prepare($query);
		$q->bindValue(':toUser', $toUser, PDO::PARAM_INT);
		$q->execute();

		$result = $q->fetch();
		return ($result[0]);
	}

	public function delete( $id ) {		
		$q = $this->_db->prepare('DELETE FROM notifications WHERE id = :id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();

		return true;
	}
}