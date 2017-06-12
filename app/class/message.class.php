<?php

class Message {
	protected $_id;
	protected $_timestamp;
	protected $_content;
	protected $_new;
	protected $_fromUser;
	protected $_toUser;

	use commonMembers;

	public function getId() { return $this->_id; }
	public function getTimestamp() { return $this->_timestamp; }
	public function getContent() { return $this->_content; }
	public function hasBeenRead() { return $this->_new; }
	public function getFromUser() { return $this->_fromUser; }
	public function getToUser() { return $this->_toUser; }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			trigger_error("Invalid ID", E_USER_WARNING);
		}
		$this->_id = $id;
		return true;
	}

	public function setToUser($toUser) {
		if (!Utilities::isDigits($toUser) || $toUser <= 0) {
			trigger_error("Invalid user ID", E_USER_WARNING);
		}
		$this->_toUser = $toUser;
		return true;
	}

	public function setFromUser($fromUser) {
		if (!Utilities::isDigits($fromUser) || $fromUser <= 0) {
			trigger_error("Invalid user ID", E_USER_WARNING);
		}
		$this->_fromUser = $fromUser;
		return true;
	}

	public function setContent($content) {
		$content = htmlspecialchars(htmlspecialchars);
		if (strlen($content) > 300) {
			trigger_error("Text too long", E_USER_WARNING);
		}
		$this->_content = $content;
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
}