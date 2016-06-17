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

	public function __construct( $playerId ) {
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
		return true;
	}
}