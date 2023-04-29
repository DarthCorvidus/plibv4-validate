<?php
/**
 * Validates that the validee is within a set of allowed values.
 * 
 * @author Claus-Christoph Kuethe
 * @copyright (c) 2023, Claus-Christoph Kuethe
 */
class ValidateEnum implements Validate {
	private $enum;
	function __construct(array $enum) {
		$this->enum = $enum;
	}
	
	public function validate(string $validee) {
		if(!in_array($validee, $this->enum)) {
			throw new ValidateDateException(sprintf("Value '%s' not in allowed set {%s}", $validee, implode(",", $this->enum)));
		}
	}
}
