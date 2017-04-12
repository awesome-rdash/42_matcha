<?php

class ProfileLike {
	protected $_id;
	protected $_idUser;
	protected $_idProfileLiked;
	protected $_time;

	use CommonMembers;

	public function getId() { return $this->_id; }
	public function getIdUser() { return $this->_idUser; }
	public function getIdProfileLiked() { return $this->_idProfileLiked; }
	public function getTime() { return $this->_time; }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("profileLike", "invalid", "id");
		}
		$this->_id = $id;
		return true;
	}

	public function setIdUser($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("profileLike", "invalid", "id_user");
		}
		$this->_idUser = $id;
		return true;
	}

	public function setIdProfileLiked($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("profileLike", "invalid", "id_picture");
		}
		$this->_idProfileLiked = $id;
		return true;
	}

	public function setTime($time) {
		if (!Utilities::isDigits($time) || $time <= 0) {
			return genError("profileLike", "invalid", "time_posted");
		}
		$this->_time = $time;
		return true;
	}
}