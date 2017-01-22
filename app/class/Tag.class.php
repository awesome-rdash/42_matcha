<?php

class Tag {
	protected $_id;
	protected $_content;

	use commonMembers;

	public function getId() { return $this->_id; }
	public function getContent() { return $this->_content; }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("tag", "invalid", "id");
		}
		$this->_id = $id;
		return true;
	}

	public function setContent($content) {
		if (strlen($nickname) > 30) {
			return (genError("tag", "toolong", "content"));
		}
		if (!ctype_alnum($nickname)) {
			return (genError("tag", "specialchar", "content"));
		}
		$this->_content = $content;
		return true;
	}
}