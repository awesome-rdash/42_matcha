<?php

Class Utilities {
	static public function sendMail($to, $subject, $message) {
		mail($to, $subject, $message);
	}
}