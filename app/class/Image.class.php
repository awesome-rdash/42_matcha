<?php

class Image {
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
			return genError("photo", "invalid", "id");
		}
		$this->_id = $id;
		return true;
	}

	public function setOwner_Id($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("photo", "invalid", "owner_id");
		}
		$this->_owner_id = $id;
		return true;
	}
}