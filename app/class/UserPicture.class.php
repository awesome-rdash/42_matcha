<?php

class UserPicture {
	protected $_id;
	protected $_upload_source;
	protected $_upload_time;
	protected $_filter_used;
	protected $_owner_id;

	use commonMembers;

	public function getId() { return $this->_id; }
	public function getUpload_source() { return $this->_upload_source; }
	public function getUpload_time() { return $this->_upload_time; }
	public function getFilter_used() { return $this->_filter_used; }
	public function getOwner_id() { return $this->_owner_id; }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			trigger_error("Invalid ID", E_USER_WARNING);
		}
		$this->_id = $id;
		return true;
	}

	public function setOwner_Id($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			trigger_error("Invalid owner ID", E_USER_WARNING);
		}
		$this->_owner_id = $id;
		return true;
	}

	public function setUpload_source($upload_source) {
		$valid_sources = array("camera", "file");
		if (!in_array($upload, $valid)) {
			trigger_error("Invalid source", E_USER_WARNING);
		}
		$this->_upload_source = $upload_source;
		return true;
	}

	public function setUpload_time($upload_time) {
		if (!Utilities::isDigits($upload_time) || $upload_time <= 0) {
			trigger_error("Invalid upload time", E_USER_WARNING);
		}
		$this->_upload_time = $upload_time;
		return true;
	}
}