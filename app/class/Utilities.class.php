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

	static public function get_client_ip_server() {
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	        $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	 
	    return $ipaddress;
	}

	static public function getLocationByIp($ip) {
		global $mapsAPI;

		$url = "freegeoip.net/json/" . $ip;

		$curl = curl_init();
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $url
			));

		$result = json_decode(curl_exec($curl), true);

		if (isset($result["ip"])) {
			$return["long"] = $result['longitude'];
			$return["lat"] = $result['latitude'];
			return $return;
		} else {
			return false;
		}
	}

	static public function ifUsersHaveTags($userId, $tagsList) {
		global $db;
		$tm = new TagManager($db);
		$tagsFromUser = $tm->getAllTagsFromMemberId($userId, "content_array");

		$nbOfTags = 0;
		foreach($tagsFromUser as $tag) {
			$tagContent = $tm->getTagContentFromId($tag->getId());
			if (in_array($tagContent, $tagsList))
				$nbOfTags++;
		}
		return $nbOfTags;
}

	static public function search_users($ageMin, $ageMax, $popMin, $popMax, $locMax, $localisationLatLong, $tags, $sexe, $sexuality, $sortMethod, $sortOrder, $currentUserId) {
		global $db;
		$mm = new MemberManager($db);
		$tm = new TagManager($db);
		$ub = new UserBlockManager($db);
		$totalUsers = $mm->getAllExistingUsers();
		$finalListOfUsers = array();

		foreach ($totalUsers as $user) {
			$member = new Member(0);
			$result = $member->hydrate($user);

			if (
				($ageMin == 0 || $member->getAge() >= $ageMin) &&
				($ageMax == 0 || $member->getAge() <= $ageMax) &&
				($popMin == 0 || $member->getPopularity() >= $popMin) &&
				($popMax == 0 || $member->getPopularity() <= $popMax) &&
				($sexe === "both" || $member->getSexe() === $sexe) &&
				($sexuality === "both" || $member->getSexual_orientation() == "both" || $member->getSexual_orientation() == $sexuality) &&
				($locMax == 0 || $localisationLatLong == NULL ||
					(Utilities::distanceBetweenTwoPoints($member->getLocationLat(), $member->getLocationLong(),
						$localisationLatLong['lat'], $localisationLatLong['long'])) <= $locMax) &&
				(empty($tags) || Utilities::ifUsersHaveTags($member->getId(), $tags) > 0) &&
				(!($ub->ifProfileIsAlreadyBlockedByUser($member->getId(), $currentUserId)))
			) {
				$finalListOfUsers[] = $member;
			}
		}

		if ($sortMethod == "age" && $sortOrder == "asc") {
			usort($finalListOfUsers, function($a, $b) {
			    return $a->getAge() <=> $b->getAge();
			});
		} else if ($sortMethod == "age" && $sortOrder == "desc"){
			usort($finalListOfUsers, function($a, $b) {
			    return $b->getAge() <=> $a->getAge();
			});
		} else if ($sortMethod == "popularity" && $sortOrder == "asc"){
			usort($finalListOfUsers, function($a, $b) {
			    return $a->getPopularity() <=> $b->getPopularity();
			});
		} else if ($sortMethod == "popularity" && $sortOrder == "desc"){
			usort($finalListOfUsers, function($a, $b) {
			    return $b->getPopularity() <=> $a->getPopularity();
			});
		} else if ($sortMethod == "tags" && $sortOrder == "asc" && !empty($tagsList)){
			usort($finalListOfUsers, function($a, $b) {
			    return ifUsersHaveTags($a->getId(), $tagsList) <=> ifUsersHaveTags($b->getId(), $tagsList);
			});
		} else if ($sortMethod == "tags" && $sortOrder == "desc" && !empty($tagsList)){
			usort($finalListOfUsers, function($a, $b) {
			    return ifUsersHaveTags($b->getId(), $tagsList) <=> ifUsersHaveTags($a->getId(), $tagsList);
			});
		} else if ($sortMethod == "localisation" && $sortOrder == "desc" && !empty($localisationLatLong)) {
			usort($finalListOfUsers, function($a, $b) {
				global $localisationLatLong;
			    return Utilities::distanceBetweenTwoPoints($a->getLocationLat(), $a->getLocationLong(), $localisationLatLong['lat'], $localisationLatLong['long']) <=> Utilities::distanceBetweenTwoPoints($b->getLocationLat(), $b->getLocationLong(), $localisationLatLong['lat'], $localisationLatLong['long']);
			});
		} else if ($sortMethod == "localisation" && $sortOrder == "asc" && !empty($localisationLatLong)) {
			usort($finalListOfUsers, function($a, $b) {
				global $localisationLatLong;
			    return Utilities::distanceBetweenTwoPoints($b->getLocationLat(), $b->getLocationLong(), $localisationLatLong['lat'], $localisationLatLong['long']) <=> Utilities::distanceBetweenTwoPoints($a->getLocationLat(), $a->getLocationLong(), $localisationLatLong['lat'], $localisationLatLong['long']);
			});
		}

		return ($finalListOfUsers);
	}
}