<?php
Class Token {
	private $_id;
	private $_user_id;
	private $_token;
	private $_time_created;
	private $_usefor;
	private $_isUsed;

	use commonMembers;

	public function getId() { return $this->_id; }
	public function getUser_id() { return $this->_user_id; }
	public function getToken() { return $this->_token; }
	public function getTime_created() { return $this->_time_created; }
	public function getUsefor() { return $this->_usefor; }
	public function getIsUsed() { return $this->_isUsed; }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id <= 0) {
			return genError("token", "invalid", "id");
		}
		$this->_id = $_id;
		if ($id == 0) {
			$this->generateToken();
		}
		return true;
	}

	public function setUser_id($id) {
		if (is_numeric($id)) {
			$this->_user_id = $id;
			return true;
		}
		return genError("token", "invalid", "userid");
	}
	
	public function setToken($token) {
		$this->_token = $token;
		return true;
	}

	public function setTime_created($time_created) {
		if (!Utilities::isDigits($time_created) || $time_created <= 0) {
			return genError("token", "invalid", "time_created");
		}
		$this->_time_created = $time_created;
		return true;
	}

	public function setUsefor($usefor) {
		if (strlen($usefor) > 20 || !ctype_alpha($usefor)) {
			return genError("token", "invalid", "usefor");
		}
		$this->_usefor = $usefor;
		return true;
	}

	public function setIsUsed($isused) {
		if ($isused) {
			$this->_isUsed = true;
		} else {
			$this->_isUsed = false;
		}
		return true;
	}

	public function generateToken() {
		$token = bin2hex(random_bytes(20));
		$this->setToken($token);
		return $this->getToken();
	}
}