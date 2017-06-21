<?php

Class Utilities {
	static public function sendMail($to, $subject, $message) {
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/plain; charset=iso-8859-1";
		$headers[] = "From: Camagru <no-reply@camagru.fr>";
		$headers[] = "Subject: $subject";
		$headers[] = "X-Mailer: PHP/".phpversion();

		mail($to, $subject, $message, implode("\r\n", $headers));
	}

	static public function isDigits($string) {
		return !preg_match("/[^0-9]/", $string);
	}

	static public function getAddress() {
			return "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/";
	}

	static public function calculateAge($timestamp = 0, $now = 0) {
	    if ($now == 0)
	        $now = time();

	    $yearDiff   = date("Y", $now) - date("Y", $timestamp);
	    $monthDiff  = date("m", $now) - date("m", $timestamp);
	    $dayDiff    = date("d", $now) - date("d", $timestamp);

	    if ($monthDiff < 0)
	        $yearDiff--;
	    elseif (($monthDiff == 0) && ($dayDiff < 0))
	        $yearDiff--;

	    return intval($yearDiff);
	}
}