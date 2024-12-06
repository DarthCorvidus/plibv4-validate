<?php
/**
 * Validate a time string of the format HH:MM:SS. ValidateTime won't accept
 * more than 23 hours per default, but can be called to accept longer times as
 * well.
 *
 * @author Claus-Christoph Küthe
 * @copyright (c) 2020, Claus-Christoph Küthe
 */
class ValidateTime implements Validate {
	/** Allows for values that exceed 23:59:59 */
	const UNLIMITED = 1;
	/** Restricts values to 23:59:59 */
	const DAY = 2;
	/** If length of time value is limited */
	private int $limit = 2;
	/**
	 * Constructs ValidateTime.
	 * @param int $limit Whether validation allows only values up to one day or more.
	 */
	function __construct(int $limit=self::DAY) {
		Assert::isClassConstant(get_class(), $limit, "limit");
		$this->limit = $limit;
	}
	
	/**
	 * Validate a string against HH:MM:SS.
	 * @param string $validee
	 * @return void
	 * @throws ValidateException
	 */
	function validate(string $validee): void {
		if(preg_match("/^[0-9]+$/", $validee)) {
			$this->validateSemantics($validee);
		return;
		}
		if(preg_match("/^[0-9]+:[0-9]{1,2}$/", $validee)) {
			$this->validateSemantics($validee);
		return;
		}
		if(preg_match("/^[0-9]+:[0-9]{1,2}:[0-9]{1,2}$/", $validee)) {
			$this->validateSemantics($validee);
		return;
		}
	throw new ValidateException("invalid format, time expected (HH:MM:SS)");
	}
	
	/**
	 * Validates the semantic content of a string, ie a minute part which is
	 * higher than 59 minutes.
	 * @param string $validee
	 * @return void
	 * @throws ValidateException
	 */
	private function validateSemantics(string $validee): void {
		$exp = explode(":", $validee);
		if($exp[0]>23 && $this->limit==self::DAY) {
			throw new ValidateException("hours out of range");
		}
		if(isset($exp[1]) && $exp[1]>59) {
			throw new ValidateException("minutes out of range");
		}
		if(isset($exp[2]) && $exp[2]>59) {
			throw new ValidateException("seconds out of range");
		}
	}
}
