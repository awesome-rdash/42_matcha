<?php

class UserPicture {
	protected $_id;
	protected $_upload_source;
	protected $_upload_time;
	protected $_filter_used;
	protected $_owner_id;
	protected $_source;

	use commonMembers;

	public function getId() { return $this->_id; }
	public function getUpload_source() { return $this->_upload_source; }
	public function getUpload_time() { return $this->_upload_time; }
	public function getFilter_used() { return $this->_filter_used; }
	public function getOwner_id() { return $this->_owner_id; }
	protected function getSource() { return $this->_source; }

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

	public function setUpload_source($upload_source) {
		$valid_sources = array("camera", "file");
		if (!in_array($upload_source, $valid_sources)) {
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

	public function setFilter_used($filter_used) {
		if (!Utilities::isDigits($filter_used) || $filter_used < 0) {
			trigger_error("Invalid filter ID", E_USER_WARNING);
		}
		$this->_filter_used = $filter_used;
		return true;
	}

	public function setSource($source) {
		$this->_source = $source;
	}

	static public function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){ 
        $cut = imagecreatetruecolor($src_w, $src_h);
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
    } 

	public function addFilter($idFilter) {
		if (!$this->setFilter_used($idFilter)) {
			return genError("userpicture", "badfilter", "addfilter");
		}
		$overlay = imagecreatefrompng("assets/img/filters/default/" . $idFilter . ".png");

		$largeur_source = imagesx($overlay);
		$hauteur_source = imagesy($overlay);
		$largeur_destination = imagesx($this->getSource());
		$hauteur_destination = imagesy($this->getSource());

		$destination_x = $largeur_destination - $largeur_source;
		$destination_y =  $hauteur_destination - $hauteur_source;

		self::imagecopymerge_alpha($this->_source, $overlay, $destination_x, $destination_y, 0, 0, $largeur_source, $hauteur_source, 100);
		return true;
	}

	public function saveToFile() {
		imagejpeg($this->getSource(), "data/userpics/" . $this->getId() . ".jpeg", 75);
	}
}