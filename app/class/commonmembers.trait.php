<?php

trait commonMembers{
	public function __construct( $mid ) {
		$this->_id = $mid;
	}

	public function hydrate( $kwargs ) {
		foreach($kwargs as $key => $value) {
			$method = "set" . ucfirst($key);
			if (method_exists($this, $method) && !empty($value)) {
				$result = $this->$method($value);
				if ($result !== true) {
					return $result;
				}
			}
		}
		return true;
	}
}