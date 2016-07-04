<?php

trait commonMembers{
	public function __construct( $id ) {
		$this->setId($id);
	}

	public function hydrate( $kwargs ) {
		foreach($kwargs as $key => $value) {
			$method = "set" . ucfirst($key);
			if (method_exists($this, $method) && isset($value)) {
				$result = $this->$method($value);
				if ($result !== true) {
					return $result;
				}
			}
		}
		return true;
	}
}