<?php

class Member {
	protected $_id;
	protected $_nickname;
	protected $_email;
	protected $_password;
	protected $_isPasswordHash;
	protected $_password2;
	protected $_register_time;
	protected $_birthdate;
	protected $_firstname;
	protected $_lastname;
	protected $_phone;
	protected $_sexe;
	protected $_bio;
	protected $_mail_confirmed;
	protected $_sexual_orientation;
	protected $_profilePicture;
	protected $_featuredPictures;
	protected $_lastLogin;
	protected $_popularity;

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
	public function getSexual_orientation() { return $this->_sexual_orientation; }
	public function getProfilePicture() { return $this->_profilePicture; }
	public function getFeaturedPictures() { return $this->_featuredPictures; }
	public function getLastLogin() { return $this->_lastLogin; }
	public function getPopularity() { return $this->_popularity; }
	public function getAge() { return Utilities::calculateAge($this->_birthdate); }

	public function setId($id) {
		if (!Utilities::isDigits($id) || $id < 0) {
			return genError("member", "invalid", "id");
		}
		$this->_id = $id;
		return true;
	}

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

	public function setPassword($password, $toHash = false) {
		if ($toHash) {
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
		if (!Utilities::isDigits($register_time) || $register_time <= 0) {
			return genError("member", "invalid", "register_time");
		}
		$this->_register_time = $register_time;
		return true;
	}

	public function setBirthdate($birthdate) {
		$this->_birthdate = $birthdate;
		return true;
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
		if ($sexe == 0 || $sexe == 1) {
			$this->_sexe = (int)$sexe;
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
		if ($mail == 0 || $mail == 1) {
			$this->_mail_confirmed = (int)$mail;
			return true;
		}
		return genError("member", "invalid", "mail_confirmed");
	}

	public function setSexual_orientation($sexual_orientation) {
		if ($sexual_orientation == "male" || $sexual_orientation == "female" || $sexual_orientation == "both") {
			$this->_sexual_orientation = $sexual_orientation;
			return true;
		}
		return genError("member", "invalid", "sexual_orientation");
	}

	public function setProfilePicture($idPicture) {
		if (is_numeric($idPicture)) {
			global $db;
			$upmanager = new UserPictureManager($db);
			if ($upmanager->ifExist($idPicture) == true) {
				$this->_profilePicture = $idPicture;
				return true;
			}
		}
		return genError("member", "invalid", "profilePicture");
	}

	public function setFeaturedPictures($pictures) {
		$featuredPictures = explode(",", $pictures);
		if ($featuredPictures === FALSE) {
			return genError("member", "explodefail", "featuredPicture");
		}

		global $db;
		$upmanager = new UserPictureManager($db);

		foreach($featuredPictures as $picture) {
			if (is_numeric($picture)) {
				if (!$upmanager->ifExist($picture)) {
					return genError("member", "unknow", "featuredPicture");
				}
			} else {
				return genError("member", "invalid", "featuredPicture");
			}
		}
		$this->_featuredPictures = $pictures;
		return true;
	}

	public function setLastLogin($lastLogin) {
		if (!Utilities::isDigits($lastLogin) || $lastLogin <= 0) {
			return genError("member", "invalid", "lastlogin");
		}
		$this->_lastLogin = $lastLogin;
		return true;
	}

	public function setPopularity($popularity) {
		if (!Utilities::isDigits($popularity) || $popularity <= 0) {
			return genError("member", "invalid", "lastlogin");
		}
		$this->_popularity = $popularity;
		return true;
	}

	public function recheckPopularity($db) {
		$profileLikeManager = new ProfileLikeManager($db);
		$numberLikes = $profileLikeManager->getNumberOfLikes($this->getId());
		$this->_popularity = $numberLikes;
		$memberManager = new MemberManager($db);
		$memberManager->update($this);
	}

	public function isPasswordConfirmationCorrect() {
		if ($this->_password == $this->_password2) {
			return true;
		} else {
			return false;
		}
	}

	public function getSexeInString() {
		if ($this->_sexe === 0) {
			return "Homme";
		} else if ($this->_sexe === 1) {
			return "Femme";
		} else {
			return "Non renseigné";
		}
	}

	public function getOrientationInString() {
		if ($this->_sexual_orientation === "male") {
			return "Hommes uniquement";
		} else if ($this->_sexual_orientation === "female") {
			return "Femmes uniquement";
		} else if ($this->_sexual_orientation === "both" ) {
			return "Femmes et hommes";
		} else {
			return "Non renseigné";
		}
	}
}