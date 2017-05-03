<?php

class ProfileVisit {
	protected $_id;
	protected $_idUser;
	protected $_idProfileVisited;
	protected $_time;

	use CommonMembers;

	public function getId() { return $this->_id; }
	public function getIdUser() { return $this->_idUser; }
	public function getIdProfileVisited() { return $this->_idProfileVisited; }
	public function getTime() { return $this->_time; }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("profileVisit", "invalid", "id");
		}
		$this->_id = $id;
		return true;
	}

	public function setIdUser($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("profileVisit", "invalid", "id_user");
		}
		$this->_idUser = $id;
		return true;
	}

	public function setIdProfileVisited($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("profileVisit", "invalid", "id_picture");
		}
		$this->_idProfileVisited = $id;
		return true;
	}

	public function setTime($time) {
		if (!Utilities::isDigits($time) || $time <= 0) {
			return genError("profileVisit", "invalid", "time_posted");
		}
		$this->_time = $time;
		return true;
	}
}