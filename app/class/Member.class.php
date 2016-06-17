<?php

class Member {
	protected $id;
	protected $nickname;
	protected $email;
	protected $password;
	protected $register_time;
	protected $birthdate;
	protected $firstname;
	protected $lastname;
	protected $phone;
	protected $sexe;
	protected $bio;
	protected $mail_confirmed;

	public function __construct( $playerID ) {
		
	}

	static public function newMemberFromRegistration( $kwargs ) {
		$toCheck = array("nickname", "email", "password", "password2", "birthdate");

		foreach($toCheck as $element) {
			if (!isset($kwargs[$element]) || empty($kwargs[$element])) {
				$error = array("element" => $element,
					"type" => "non-present");
				return $error;
			}
		}

		$kwargs['password'] = hash("whirlpool", $kwargs['password']);
		$kwargs['password2'] = hash("whirlpool", $kwargs['password2']);
		if ($kwargs['password'] !== $kwargs['password2']) {
			$error = array("element" => "password",
				"type" => "notthesame");
			return $error;
		}
	}
}