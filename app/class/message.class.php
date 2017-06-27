<?php

class Message {
	protected $_id;
	protected $_time_posted;
	protected $_content;
	protected $_new;
	protected $_fromUser;
	protected $_toUser;

	use commonMembers;

	public function getId() { return $this->_id; }
	public function getTime_posted() { return $this->_time_posted; }
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
		$content = trim($content);
		if (empty($content)) {
			return $error = "empty";
		}
		$content = htmlspecialchars($content);
		if (strlen($content) > 300) {
			return $error = "toolong";
		}
		$this->_content = $content;
		return true;
	}

	public function setTime_posted($time) {
		if (!Utilities::isDigits($time) || $time <= 0) {
			trigger_error("Invalid upload time", E_USER_WARNING);
		}
		$this->_time_posted = $time;
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