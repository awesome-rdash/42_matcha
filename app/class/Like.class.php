<?php

class Like {
	protected $_id;
	protected $_id_user;
	protected $_id_picture;
	protected $_time_liked;

	use CommonMembers;

	public function getId() { return $this->_id; }
	public function getId_user() { return $this->_id_user; }
	public function getId_picture() { return $this->_id_picture; }
	public function getTime_liked() { return $this->_time_liked; }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("like", "invalid", "id");
		}
		$this->_id = $id;
		return true;
	}

	public function setId_user($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("like", "invalid", "id_user");
		}
		$this->_id_user = $id;
		return true;
	}

	public function setId_picture($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("like", "invalid", "id_picture");
		}
		$this->_id_picture = $id;
		return true;
	}

	public function setTime_liked($time) {
		if (!Utilities::isDigits($time) || $time <= 0) {
			return genError("like", "invalid", "time_posted");
		}
		$this->_time_posted = $time;
		return true;
	}
}