<?php
/**
 * Validates minimum and maximum length of a string
 * 
 * @author Claus-Christoph Kuethe
 * @copyright (c) 2023, Claus-Christoph Kuethe
 */
class ValidateMinMaxString implements Validate {
	private $min;
	private $max;
	private $charset;
	function __construct(int $min, int $max, string $charset="UTF-8") {
		$this->min = $min;
		$this->max = $max;
		$this->charset = $charset;
	}
	
	public function validate(string $validee) {
		if(mb_strlen($validee)<$this->min) {
			throw new ValidateException(sprintf("value too short, min %d characters.", $this->min));
		}
		
		if(mb_strlen($validee)>$this->max) {
			throw new ValidateException(sprintf("value too long, max %d characters.", $this->max));
		}
			
	}

}
