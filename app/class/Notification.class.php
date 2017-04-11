<?php

class Notification {
	protected $_id;
	protected $_timestamp;
	protected $_type;
	protected $_new;
	protected $_user;

	use commonMembers;

	public function getId() { return $this->_id; }
	public function getTimestamp() { return $this->_timestamp; }
	public function getType() { return $this->_type; }
	public function hasBeenRead() { return $this->_new; }
	public function getUser() { return $this->_user; }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			trigger_error("Invalid ID", E_USER_WARNING);
		}
		$this->_id = $id;
		return true;
	}

	public function setUser($user) {
		if (!Utilities::isDigits($user) || $user <= 0) {
			trigger_error("Invalid user ID", E_USER_WARNING);
		}
		$this->_user = $user;
		return true;
	}

	public function setType($type) {
		$valid_sources = array("like", "visit", "mutualLike", "message", "unLike");
		if (!in_array($type, $valid_sources)) {
			trigger_error("Invalid id", E_USER_WARNING);
		}
		$this->_type = $_type;
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
		if (!is_bool($new)) {
			trigger_error("Invalid read statement", E_USER_WARNING);
		}
		$this->new = $new;
		return true;
	}
}