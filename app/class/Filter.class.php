<?php

class UserPicture {
	protected $_id;
	protected $_upload_time;
	protected $_owner_id;
	protected $_source;

	use commonMembers;

	public function getId() { return $this->_id; }
	public function getUpload_time() { return $this->_upload_time; }
	public function getOwner_id() { return $this->_owner_id; }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			trigger_error("Invalid ID", E_USER_WARNING);
		}
		$this->_id = $id;
		return true;
	}

	public function setOwner_Id($id) {
		if (!Utilities::isDigits($id) || $id <= 0) {
			trigger_error("Invalid owner ID", E_USER_WARNING);
		}
		$this->_owner_id = $id;
		return true;
	}

	public function setUpload_time($upload_time) {
		if (!Utilities::isDigits($upload_time) || $upload_time <= 0) {
			trigger_error("Invalid upload time", E_USER_WARNING);
		}
		$this->_upload_time = $upload_time;
		return true;
	}
	
	public function setSource($source) {
		$this->_source = $source;
	}
}