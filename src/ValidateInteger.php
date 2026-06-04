<?php
namespace plibv4\validate;
final class ValidateInteger implements Validate {
	private bool $allowNegative = true;
	function __construct(bool $allowNegative = true) {
		$this->allowNegative = $allowNegative;
	}
	#[\Override]
	public function validate(string $validee): void {
		/**
		 * 
		 */
		if(preg_match("/^[0-9]*$/", $validee)) {
			return;
		}
		if($this->allowNegative && preg_match("/^-[0-9]*$/", $validee)) {
			return;
		}
		if(!$this->allowNegative) {
			throw new ValidateException("not a valid positive integer");		
		}
	throw new ValidateException("not a valid integer");
	}
}