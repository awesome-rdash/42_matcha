<?php

Class Utilities {
	static public function sendMail($to, $subject, $message) {
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/plain; charset=iso-8859-1";
		$headers[] = "From: Camagru <no-reply@camagru.fr>";
		$headers[] = "Subject: {$subject}";
		$headers[] = "X-Mailer: PHP/".phpversion();

		mail($to, $subject, $message, implode("\r\n", $headers));
	}

	static public function isDigits($string) {
		return !preg_match("/[^0-9]/", $element);
	}
}

Utilities::sendMail("jrouzier@outlook.com", "test", "test");