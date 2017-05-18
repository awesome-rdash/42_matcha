<?php

class UserReport {
	protected $_id;
	protected $_FromUser;
	protected $_ToUserReported;
	protected $_time;

	use CommonMembers;

	public function getId() { return $this->_id; }
	public function getIdUser() { return $this->_FromUser; }
	public function getIdProfileLiked() { return $this->_ToUserReported; }
	public function getTime() { return $this->_time; }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("UserReport", "invalid", "id");
		}
		$this->_id = $id;
		return true;
	}

	public function setFromUser($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("UserReport", "invalid", "id_user");
		}
		$this->_FromUser = $id;
		return true;
	}

	public function setToUserReported($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("UserReport", "invalid", "id_reported_user");
		}
		$this->_ToUserReported = $id;
		return true;
	}

	public function setTime($time) {
		if (!Utilities::isDigits($time) || $time <= 0) {
			return genError("UserReport", "invalid", "time_posted");
		}
		$this->_time = $time;
		return true;
	}
}