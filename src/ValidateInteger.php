<?php

class ValidateInteger implements Validate {
	public function validate(string $validee): void {
		if(preg_match("/^[0-9]*$/", $validee)) {
			return;
		}
	throw new ValidateException("not a valid integer");
	}
}