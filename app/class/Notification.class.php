<?php

class Notification {
	protected $_id;
	protected $_timestamp;
	protected $_type;
	protected $_new;
	protected $_transmitter;
	protected $_receiver;

	use commonMembers;

	public function getId() { return $this->_id; }
	public function getTimestamp() { return $this->_timestamp; }
	public function getType() { return $this->_type; }
	public function hasBeenRead() { return $this->_new; }
	public function getTransmitter() { return $this->_transmitter; }
	public function getRecipient() { return $this->_receiver; }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			trigger_error("Invalid ID", E_USER_WARNING);
		}
		$this->_id = $id;
		return true;
	}

	public function setToUser($receiver) {
		if (!Utilities::isDigits($receiver) || $receiver <= 0) {
			trigger_error("Invalid user ID", E_USER_WARNING);
		}
		$this->_receiver = $receiver;
		return true;
	}

	public function setFromUser($transmitter) {
		if (!Utilities::isDigits($transmitter) || $transmitter <= 0) {
			trigger_error("Invalid user ID", E_USER_WARNING);
		}
		$this->_transmitter = $transmitter;
		return true;
	}

	public function setType($type) {
		$valid_sources = array("like", "visit", "mutualLike", "message", "unLike");
		if (!in_array($type, $valid_sources)) {
			trigger_error("Invalid id", E_USER_WARNING);
		}
		$this->_type = $type;
		return true;
	}

	public function setTimestamp($timestamp) {
		if (!Utilities::isDigits($timestamp) || $timestamp <= 0) {
			trigger_error("Invalid upload time", E_USER_WARNING);
		}
		$this->_timestamp = $timestamp;
		return true;
	}

	public function setNew($new) {
		if ($new == 1 || $new == 0) {
			$this->_new = $new;
			return true;
		}
		trigger_error("Invalid read statement", E_USER_WARNING);
	}

	public function getStringFromNotification($db) {
		$memberManager = new MemberManager($db);
		$fromUser = $memberManager->getFromId($this->_transmitter);
		$end = "";

		switch ($this->_type) {
			case "like":
				$end = "a aimé votre profil";
				break;
			case "visit":
				$end = "a visité votre profil";
				break;
			case "mutualLike":
				$end = "a aimé votre profil en retour";
				break;
			case "message":
				$end = "vous a envoyé un message";
				break;
			case "unLike":
				$end = "n'aime plus votre profil";
				break;
		}
		$return = $fromUser->getFirstName() . " " . $fromUser->getLastName() . " " . $end . ".";
		return ($return);
	}
}