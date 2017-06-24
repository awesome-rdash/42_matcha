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

	static public function getLongLatFromString($string) {
		if (empty($string))
			return false;

		global $mapsAPI;

		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($string) .
		"&key=" . $mapsAPI;

		$curl = curl_init();
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url
			));

		$result = json_decode(curl_exec($curl), true);

		if ($result["status"] == "OK") {
			$return["long"] = $result['results'][0]['geometry']['location']['lng'];
			$return["lat"] = $result['results'][0]['geometry']['location']['lat'];
			return $return;
		} else {
			return false;
		}
	}

	static public function distanceBetweenTwoPoints($lat1, $lon1, $lat2, $lon2) {
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$km = $dist * 60 * 1.1515 * 1.609344;
		return ($km);
	}

	static public function getLocationInString($lat, $long) {
		if ($lat == 0 || $long == 0)
			return false;

		global $mapsAPI;

		$url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" . $lat .
		"," . $long .
		"&key=" . $mapsAPI;

		$curl = curl_init();
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url
			));
		$result = json_decode(curl_exec($curl), true);

		if ($result["status"] == "OK") {
			return $result['results'][0]["formatted_address"];
		} else {
			return false;
		}
	}
}