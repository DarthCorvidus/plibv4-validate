<?php
namespace plibv4\validate;
use Assert;

/**
 * Exception if ValidateDate fails.
 * 
 * Class constants can be used to message cause of failure to catch block.
 * @author Claus-Christoph Kuethe
 * @copyright (c) 2020, Claus-Christoph Kuethe
 */
class ValidateDateException extends ValidateException {
	/** If syntax validation fails (ie: wrong format)*/
	const VD_SYNTAX = 1;
	/** If days are out of range (31.02.2020) */
	const VD_DAY_OOR = 2;
	/** If months are out of range (31.13.2020) */
	const VD_MONTH_OOR = 3;
}
/**
 * Validates several date formats.
 *
 * @author Claus-Christoph Kuethe
 * @copyright (c) 2020, Claus-Christoph Kuethe
 */
class ValidateDate implements Validate {
	/** ISO 8601 compliant date (YYYY-MM-DD) */
	const ISO = 0;
	/** Pre 1996 DIN 5008 german date (DD.MM.YYYY)  */
	const GERMAN = 1;
	/** US-style date (MM/DD/YYYY) */
	const US = 2;
	/** 
	 * Regular expression reflecting format
	 * @var non-empty-string
	 */
	private string $regex;
	/** example of format to include in exception */
	private string $format;
	/** format to be validated against */
	private int $id;
	/**
	 * Creates ValidateDate.
	 * @param int $format class constant designating format
	 */
	function __construct(int $format) {
		Assert::isClassConstant(self::class, $format, "format");
		$this->id = $format;
		/**
		 * Default to ISO 8601
		 */
		$this->regex = "/^[0-9]+-[0-9]{1,2}-[0-9]{1,2}$/";
		$this->format = "YYYY-MM-DD";
		if($format == self::GERMAN) {
			$this->regex = "/^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]+$/";
			$this->format = "DD.MM.YYYY";
		}
		if($format == self::US) {
			$this->regex = "/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]+$/";
			$this->format = "MM/DD/YYYY";
		}
	}
	/**
	 * Disassembles string into numeric array.
	 * The string to be validated is first disassembled to an array to do
	 * "semantic" validation.
	 * @param string $validee 
	 * @return array
	 */
	private function stringToArray(string $validee): array {
		if($this->id===self::ISO) {
			$exp = explode("-", $validee);
		return array($exp[0], $exp[1], $exp[2]);
		}
		if($this->id==self::GERMAN) {
			$exp = explode(".", $validee);
		return array($exp[2], $exp[1], $exp[0]);
		}
		if($this->id==self::US) {
			$exp = explode("/", $validee);
		return array($exp[2], $exp[0], $exp[1]);
		}
	// should not trip
	throw new \RuntimeException("unable to parse ".$validee." into array for format ".$this->id);
	}
	/**
	 * Semantic validation of date as array.
	 * Does a semantic validation on array given by stringToArray. Checks for
	 * invalid months or days.
	 * @param array $date Contains three entries year, month, day.
	 * @return void
	 * @throws ValidateException
	 */
	private function validateSemantics(array $date) {
		if($date[1]<=0 || $date[1]>=13) {
			throw new ValidateException("Month is out of range", ValidateDateException::VD_MONTH_OOR);
		}
		if($date[2]<=0) {
			throw new ValidateException("day is out of range", ValidateDateException::VD_DAY_OOR);
		}
		if($date[2]<=28) {
			return;
		}
		$parseMe = (string)$date[0]."-".(string)$date[1]."-01";
		$ts = strtotime($parseMe);
		if($ts === false) {
			// should not happen.
			throw new \RuntimeException("unable to parse date ".$parseMe);
		}
		if(date("t", $ts)<$date[2]) {
			throw new ValidateException("day is out of range", ValidateDateException::VD_DAY_OOR);
		}
	}
	/**
	 * Validates string against selected format.
	 * Validates string containing date against proper syntax for desired format
	 * as well as proper values for days and month. Does not accept invalid dates
	 * such as 2020-06-31.
	 * 
	 * Note that validate accepts „sloppy“ formats such as 2020-6-1.
	 * @param string $validee string containing date
	 * @return void
	 * @throws ValidateException
	 */
	public function validate(string $validee): void {
		if(!preg_match($this->regex, $validee)) {
			throw new ValidateException("Invalid format, ".$this->format." expected", ValidateDateException::VD_SYNTAX);
		}
		$array = $this->stringToArray($validee);
		$this->validateSemantics($array);
	}
}
