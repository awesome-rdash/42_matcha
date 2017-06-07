<?php

class UserBlock {
	protected $_id;
	protected $_fromUser;
	protected $_toUserBlocked;
	protected $_time;

	use CommonMembers;

	public function getId() { return $this->_id; }
	public function getFromUser() { return $this->_fromUser; }
	public function getToUserBlocked() { return $this->_toUserBlocked; }
	public function getTime() { return $this->_time; }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("userBlock", "invalid", "id");
		}
		$this->_id = $id;
		return true;
	}

	public function setFromUser($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("userBlock", "invalid", "id_user");
		}
		$this->_fromUser = $id;
		return true;
	}

	public function setToUserBlocked($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("userBlock", "invalid", "id_blocked_user");
		}
		$this->_toUserBlocked = $id;
		return true;
	}

	public function setTime($time) {
		if (!Utilities::isDigits($time) || $time <= 0) {
			return genError("userBlock", "invalid", "time_posted");
		}
		$this->_time = $time;
		return true;
	}
}