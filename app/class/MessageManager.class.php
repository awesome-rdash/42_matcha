<?php

class MessageManager {
	protected $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function create(Notification $notification) {
		$q = $this->_db->prepare('
			INSERT INTO messages(id, timestamp, content, new, toUser, fromUser)
			VALUES(:id, :timestamp, :content, :new, :toUser, :fromUser)');
		$q->bindValue(':id', $notification->getId(), PDO::PARAM_INT);
		$q->bindValue(':timestamp', time(), PDO::PARAM_INT);
		$q->bindValue(':content', $notification->getContent(), PDO::PARAM_STR);
		$q->bindValue(':new', $notification->hasBeenRead(), PDO::PARAM_INT);
		$q->bindValue(':fromUser', $notification->getFromUser(), PDO::PARAM_INT);
		$q->bindValue(':toUser', $notification->getToUser(), PDO::PARAM_INT);

		$q->execute();

		$notification->setId($this->_db->lastInsertId());
		return ($notification->getId());
	}

	public function update(Notification $notification) {
		$q = $this->_db->prepare('
			UPDATE messages
			SET timestamp = :timestamp, content = :content, new = :new, toUser = :toUser, fromUser = :fromUser
			WHERE id = :id');
		$q->bindValue(':timestamp', time(), PDO::PARAM_INT);
		$q->bindValue(':content', $notification->getContent(), PDO::PARAM_STR);
		$q->bindValue(':new', $notification->hasBeenRead(), PDO::PARAM_INT);
		$q->bindValue(':fromUser', $notification->getTransmitter(), PDO::PARAM_INT);
		$q->bindValue(':toUser', $notification->getRecipient(), PDO::PARAM_INT);
		$q->bindValue(':id', $notification->getId(), PDO::PARAM_INT);

		$q->execute();
	}

	public function get( $id ) {
		$q = $this->_db->prepare('SELECT * FROM messages WHERE id = :id');
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

	public function getUnreadMessages($toUser, $fromUser) {
		$query = "SELECT * FROM messages WHERE new = 1 AND toUser = :toUser AND fromUser = :fromUser";
		$q = $this->_db->prepare($query);
		$q->bindValue(':toUser', $toUser, PDO::PARAM_INT);
		$q->bindValue(':fromUser', $fromUser, PDO::PARAM_INT);
		$q->execute();

		$result = array();
		while($data = $q->fetch()) {
			$message = new Message(0);
			$message->hydrate($data);
			$result[] = $message;
		}
		return ($result);
	}

	public function getUnreadMessagesCount($toUser) {
		$query = "SELECT COUNT(*) FROM messages WHERE new = 1 AND toUser = :toUser";
		$q = $this->_db->prepare($query);
		$q->bindValue(':toUser', $toUser, PDO::PARAM_INT);
		$q->execute();

		$result = $q->fetch();
		return ($result[0]);
	}

	public function notificationsBetweenTwoTimestamp($toUser, $time1, $time2) {
		$query = "SELECT * FROM messages WHERE new = 1 AND toUser = :toUser AND timestamp > :time1 AND timestamp < :time2";
		$q = $this->_db->prepare($query);
		$q->bindValue(':toUser', $toUser, PDO::PARAM_INT);
		$q->bindValue(':time1', $time1, PDO::PARAM_INT);
		$q->bindValue(':time2', $time2, PDO::PARAM_INT);
		$q->execute();

		while($data = $q->fetch()) {
			$notification = new Notification(0);
			$notification->hydrate($data);
			$result[] = $notification;
		}
		return ($result);
	}

	public function markAllAsReadForUser($userId) {
		$unread = $this->getUnreadNotificationsToUser($userId);
		foreach ($unread as $notification) {
			$notification->setNew(0);
			$this->update($notification);
		}
	}

	public function generateNotification($type, $toUser, $fromUser) {
		$notificationParameters = array (
			"type" => $type,
			"toUser" => $toUser,
			"fromUser" => $fromUser,
			"new" => 1);
		$notification = new Notification(0);
		$notification->hydrate($notificationParameters);
		if ($notification != FALSE) {
			$return = $this->create($notification);
			return $return;
		} else {
			return $notification;
		}
	}

	public function delete( $id ) {		
		$q = $this->_db->prepare('DELETE FROM notifications WHERE id = :id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();

		return true;
	}
}