<?php

class Member {
	protected $id;
	protected $nickname;
	protected $email;
	protected $password;
	protected $password2;
	protected $register_time;
	protected $birthdate;
	protected $firstname;
	protected $lastname;
	protected $phone;
	protected $sexe;
	protected $bio;
	protected $mail_confirmed;

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
		$this->nickname = $nickname;
		return true;
	}

	public function setEmail($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return (genError("register", "notvalid", "email"));
		}
		if (strlen($email) >= 255) {
			return (genError("register", "toolong", "email"));
		}
		$this->email = $email;
		return true;
	}

	public function setPassword($password) {
		if (strlen($password) < 6) {
			return (genError("register", "tooshort", "password"));
		}
		if (strlen($password) > 200) {
			return (genError("register", "toolong", "password"));
		}
		$this->$password = hash("whirlpool", $password);
		return true;
	}
}