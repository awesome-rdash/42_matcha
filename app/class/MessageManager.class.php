<?php

class MessageManager {
	protected $_db;

	public function __construct($db) {
		$this->_db = $db;
	}

	public function create(Message $message) {
		$q = $this->_db->prepare('
			INSERT INTO messages(time_posted, content, new, toUser, fromUser)
			VALUES(:time_posted, :content, :new, :toUser, :fromUser)');
		$q->bindValue(':time_posted', time(), PDO::PARAM_INT);
		$q->bindValue(':content', $message->getContent(), PDO::PARAM_STR);
		$q->bindValue(':new', $message->hasBeenRead(), PDO::PARAM_INT);
		$q->bindValue(':fromUser', $message->getFromUser(), PDO::PARAM_INT);
		$q->bindValue(':toUser', $message->getToUser(), PDO::PARAM_INT);

		$q->execute();

		$message->setId($this->_db->lastInsertId());
		return ($message->getId());
	}

	public function update(Message $message) {
		$q = $this->_db->prepare('
			UPDATE messages
			SET time_posted = :time_posted, content = :content, new = :new, toUser = :toUser, fromUser = :fromUser
			WHERE id = :id');
		$q->bindValue(':time_posted', time(), PDO::PARAM_INT);
		$q->bindValue(':content', $message->getContent(), PDO::PARAM_STR);
		$q->bindValue(':new', $message->hasBeenRead(), PDO::PARAM_INT);
		$q->bindValue(':fromUser', $message->getTransmitter(), PDO::PARAM_INT);
		$q->bindValue(':toUser', $message->getRecipient(), PDO::PARAM_INT);
		$q->bindValue(':id', $message->getId(), PDO::PARAM_INT);

		$q->execute();
	}

	public function get( $id ) {
		$q = $this->_db->prepare('SELECT * FROM messages WHERE id = :id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();

		$donnees = $q->fetch();

		if ($q->rowCount() > 0) {
			$message = new Message($donnees['id']);
			$message->hydrate($donnees);
			return ($message);
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

	public function getAllMessagesBetweenTwoUsers($fromUser, $toUser) {
		$query = "SELECT * FROM messages WHERE (toUser = :toUser OR toUser = :fromUser) AND (fromUser = :fromUser OR fromUser = :toUser) ORDER BY time_posted DESC";
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

	public function getMessagesBetweenTwoTimestamp($toUser, $fromUser, $time1) {
		$query = "SELECT * FROM messages WHERE toUser = :toUser AND fromUser = :fromUser AND time_posted > :time1 ORDER BY time_posted ASC";
		$q = $this->_db->prepare($query);
		$q->bindValue(':toUser', $toUser, PDO::PARAM_INT);
		$q->bindValue(':fromUser', $fromUser, PDO::PARAM_INT);
		$q->bindValue(':time1', $time1, PDO::PARAM_INT);
		$q->execute();

		$result = array();
		while($data = $q->fetch()) {
			$message = new Message(0);
			$message->hydrate($data);
			$result[] = $message;
		}
		return ($result);
	}

	public function generateMessage($content, $toUser, $fromUser) {
		$messageP = array (
			"content" => htmlspecialchars($content),
			"toUser" => $toUser,
			"fromUser" => $fromUser,
			"new" => 1);
		$message = new Message(0);
		$message->hydrate($messageP);
		if ($message != FALSE) {
			$return = $this->create($message);
			return $return;
		} else {
			return $message;
		}
	}

	public function delete( $id ) {		
		$q = $this->_db->prepare('DELETE FROM message WHERE id = :id');
		$q->bindValue(':id', $id, PDO::PARAM_INT);
		$q->execute();

		return true;
	}
}