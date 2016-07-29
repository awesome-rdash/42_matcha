<?php

class Comment {
	protected $_id;
	protected $_id_user;
	protected $_id_picture;
	protected $_content;
	protected $_time_posted;

	use CommonMembers;

	public function getId() { return $this->_id; }
	public function getId_user() { return $this->_id_user; }
	public function getId_picture() { return $this->_id_picture; }
	public function getContent() { return $this->_content; }
	public function getTime_posted() { return $this->_time_posted; }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("comment", "invalid", "id");
		}
		$this->_id = $id;
		return true;
	}

	public function setId_user($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("comment", "invalid", "id_user");
		}
		$this->_id_user = $id;
		return true;
	}

	public function setId_picture($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("comment", "invalid", "id_picture");
		}
		$this->_id_picture = $id;
		return true;
	}

	public function setContent($text) {
		if (strlen($text) > 255) {
			return genError("comment", "toolong", "text");
		}
		$this->_content = $text;
		return true;
	}

	public function setTime_posted($time) {
		if (!Utilities::isDigits($time) || $time <= 0) {
			return genError("member", "invalid", "time_posted");
		}
		$this->_time_posted = $time;
		return true;
	}
}