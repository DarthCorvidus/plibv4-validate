<?php
/**
 * Validates that the validee is within a set of allowed values.
 * 
 * @author Claus-Christoph Kuethe
 * @copyright (c) 2023, Claus-Christoph Kuethe
 */
namespace plibv4\validate;

final class ValidateEnum implements Validate {
	/** @var list<string> */
	private array $enum = array();
	/**
	 * 
	 * @param list<string> $enum
	 */
	function __construct(array $enum) {
		$this->enum = $enum;
	}
	
	#[\Override]
	public function validate(string $validee): void {
		if(!in_array($validee, $this->enum, true)) {
			/** @psalm-suppress MixedArgumentTypeCoercion */
			throw new ValidateDateException(sprintf("Value '%s' not in allowed set {%s}", $validee, implode(",", $this->enum)));
		}
	}
}
