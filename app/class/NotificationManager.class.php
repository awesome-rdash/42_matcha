<?php

class NotificationManager {
	protected $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function new(Notification $notification) {
		$q = $this->_db->prepare('
			INSERT INTO notifications(id, timestamp, type, new, user)
			VALUES(:id, :timestamp, :type, :new, :user)');
		$q->bindValue(':id', $notification->getId(), PDO::PARAM_STR);
		$q->bindValue(':timestamp', $notification->getTimestamp(), PDO::PARAM_INT);
		$q->bindValue(':type', $notification->getType(), PDO::PARAM_STR);
		$q->bindValue(':new', $notification->hasBeenRead(), PDO::PARAM_INT);
		$q->bindValue(':user', $notification->getUser(), PDO::PARAM_INT);

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

	public function getUnreadNotificationsFromUser($user_id) {
		$query = "SELECT * FROM notifications WHERE new = 1 AND id = :id";
		$q->bindValue(':id', $user_id, PDO::PARAM_INT);
		$q = $this->_db->prepare($query);
		$q->execute();

		foreach($q->fetch as $data) {
			$result[] = new Notification($data);
		}
		return ($result);
	}

	public function getUnreadNotificationCount($user_id) {
		$query = "SELECT COUNT(*) FROM notifications WHERE new = 1 AND id = :id";
		$q->bindValue(':id', $user_id, PDO::PARAM_INT);
		$q = $this->_db->prepare($query);
		$q->execute();

		$result = $q->fetch();
		return ($result);
	}

	public function delete( $id ) {		
		$q = $this->_db->prepare('DELETE FROM notifications WHERE id = :id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();

		return true;
	}
}