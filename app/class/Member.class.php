<?php

class Member {
	protected $_id;
	protected $_nickname;
	protected $_email;
	protected $_password;
	protected $_password2;
	protected $_register_time;
	protected $_birthdate;
	protected $_firstname;
	protected $_lastname;
	protected $_phone;
	protected $_sexe;
	protected $_bio;
	protected $_mail_confirmed;

	public function __construct( $mid ) {
		$this->id = $mid;
	}

	public function hydrate( $kwargs ) {
		foreach($kwargs as $key => $value) {
			$method = "set" . ucfirst($key);
			if (method_exists($this, $method)) {
				$result = $this->$method($value);
				if ($result !== true) {
					return $result;
				}
			}
		}
		return true;
	}

	public function setNickname($nickname) {
		if (strlen($nickname) < 3) {
			return (genError("register", "tooshort", "nickname"));
		}
		if (strlen($nickname) > 15) {
			return (genError("register", "toolong", "nickname"));
		}
		if (!ctype_alnum($nickname)) {
			return (genError("register", "specialchar", "nickname"));
		}
		$this->_nickname = $nickname;
		return true;
	}

	public function setEmail($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return (genError("register", "notvalid", "email"));
		}
		if (strlen($email) >= 255) {
			return (genError("register", "toolong", "email"));
		}
		$this->_email = $email;
		return true;
	}

	public function setPassword($password) {
		if (strlen($password) < 6) {
			return (genError("register", "tooshort", "password"));
		}
		if (strlen($password) > 200) {
			return (genError("register", "toolong", "password"));
		}
		$this->_password = hash("whirlpool", $password);
		return true;
	}

	public function setPassword2($password2) {
		$this->_password2 = hash("whirlpool", $password2);
		return true;
	}

	public function isPasswordConfirmationCorrect() {
		if ($this->_password === $this->_password2) {
			return true;
		} else {
			return false;
		}
	}
}