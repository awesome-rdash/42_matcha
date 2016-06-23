<?php
Class Token {
	private $_id;
	private $_user_id;
	private $_token;
	private $_time_created;
	private $_usefor;
	private $_isUsed;

	use commomMembers;

	public function getId() { return $this->_id; }
	public function getUser_id() { return $this->_user_id; }
	public function getToken() { return $this->_token; }
	public function getTime_created() { return $this->_time_created; }
	public function getUsefor() { return $this->_usefor; }
	public function getIsUsed() { return $this->_isUsed; }

	public function setUser_id($id) {
		if (is_numeric($id)) {
			$this->_user_id = $id;
			return true;
		}
		return genError("token", "invalid", "userid");
	}

	public function 
}