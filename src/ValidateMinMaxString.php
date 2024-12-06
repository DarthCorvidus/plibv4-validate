<?php
/**
 * Validates minimum and maximum length of a string
 * 
 * @author Claus-Christoph Kuethe
 * @copyright (c) 2023, Claus-Christoph Kuethe
 */
class ValidateMinMaxString implements Validate {
	private int $min;
	private int $max;
	private string $charset;
	function __construct(int $min, int $max, string $charset="UTF-8") {
		$this->min = $min;
		$this->max = $max;
		$this->charset = $charset;
	}
	
	public function validate(string $validee): void {
		if(mb_strlen($validee)<$this->min) {
			throw new ValidateException(sprintf("value too short, min %d characters.", $this->min));
		}
		
		if(mb_strlen($validee)>$this->max) {
			throw new ValidateException(sprintf("value too long, max %d characters.", $this->max));
		}
			
	}

}
