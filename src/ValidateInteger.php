<?php
namespace plibv4\validate;
final class ValidateInteger implements Validate {
	#[\Override]
	public function validate(string $validee): void {
		if(preg_match("/^[0-9]*$/", $validee)) {
			return;
		}
	throw new ValidateException("not a valid integer");
	}
}