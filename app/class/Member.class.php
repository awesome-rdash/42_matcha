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

	use commonMembers;

	public function getId() { return $this->_id; }
	public function getNickname() { return $this->_nickname; }
	public function getEmail() { return $this->_email; }
	public function getPassword() { return $this->_password; }
	public function getRegister_time() { return $this->_register_time; }
	public function getBirthdate() { return $this->_birthdate; }
	public function getFirstname() { return $this->_firstname; }
	public function getLastname() { return $this->_lastname; }
	public function getPhone() { return $this->_phone; }
	public function getSexe() { return $this->_sexe; }
	public function getBio() { return $this->_bio; }
	public function getMail_confirmed() { return $this->_mail_confirmed; }

	public function setNickname($nickname) {
		if (strlen($nickname) < 3) {
			return (genError("member", "tooshort", "nickname"));
		}
		if (strlen($nickname) > 15) {
			return (genError("member", "toolong", "nickname"));
		}
		if (!ctype_alnum($nickname)) {
			return (genError("member", "specialchar", "nickname"));
		}
		$this->_nickname = $nickname;
		return true;
	}

	public function setEmail($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return (genError("member", "notvalid", "email"));
		}
		if (strlen($email) >= 255) {
			return (genError("member", "toolong", "email"));
		}
		$this->_email = $email;
		return true;
	}

	public function setPassword($password) {
		if ($this->_id == 0) {
			if (strlen($password) < 6) {
				return (genError("member", "tooshort", "password"));
			}
			if (strlen($password) > 200) {
				return (genError("member", "toolong", "password"));
			}
			$this->_password = hash("whirlpool", $password);
		} else {
			$this->_password = $password;
		}
		return true;
	}

	public function setPassword2($password2) {
		$this->_password2 = hash("whirlpool", $password2);
		return true;
	}

	public function setRegister_time($register_time) {
		if (!Utilities::isDigits($register_time) || $register_time <= 0	) {
			return genError("member", "invalid", "register_time");
		}
		$this->_register_time = $register_time;
		return true;
	}

	public function setBirthdate($birthdate) {
		$this->_birthdate = $birthdate;
	}

	public function setFirstname($firstname) {
		if (strlen($firstname) > 20) {
			return genError("member", "toolong", "firstname");
		}
		if (!ctype_alpha($firstname)) {
			return genError("member", "invalid", "firstname");
		}
		$this->_firstname = $firstname;
		return true;
	}

	public function setLastname($lastname) {
		if (strlen($lastname) > 20) {
			return genError("member", "toolong", "lastname");
		}
		if (!ctype_alpha($lastname)) {
			return genError("member", "invalid", "lastname");
		}
		$this->_lastname = $lastname;
		return true;
	}

	public function setPhone($phone) {
		if (strlen($phone) != 10) {
			return genError("member", "incorrectsize", "phone");
		}
		if (!is_numeric($phone)) {
			return genError("member", "invalid", "phone");
		}
		$this->_phone = $phone;
		return true;
	}

	public function setSexe($sexe) {
		if ($sexe == 1 || $sexe == 2) {
			$this->_sexe = $sexe;
			return true;
		}
		return genError("member", "invalid", "sexe");
	}

	public function setBio($bio) {
		if (strlen($bio) > 1000) {
			return genError("member", "toolong", "bio");
		}
		$this->_bio = $bio;
		return true;
	}

	public function setMail_confirmed($mail) {
		if ($mail === false || $mail === true) {
			$this->_mail_confirmed = $mail;
			return true;
		}
		return genError("member", "invalid", "mail_confirmed");
	}

	public function isPasswordConfirmationCorrect() {
		if ($this->_password == $this->_password2) {
			return true;
		} else {
			return false;
		}
	}
}