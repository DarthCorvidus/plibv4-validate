<?php
/**
 * @copyright (c) 2021, Claus-Christoph Küthe
 * @author Claus-Christoph Küthe <floss@vm01.telton.de>
 * @license LGPL
 */
namespace plibv4\validate;
use plibv4\assert\Assert;

/**
 * Validate path
 * 
 * Validate a path, leaving the option to demand a file or a directory.
 */
final class ValidatePath implements Validate {
	private int $type;
	const DIR = 1;
	const FILE = 2;
	const BOTH = 3;
	/**
	 * Construct ValidatePath
	 * @param int $format directory, file or both
	 */
	function __construct(int $type) {
		Assert::isClassConstant(self::class, $type, "type");
		$this->type = $type;
	}

	#[\Override]
	public function validate(string $validee): void {
		if(!file_exists($validee)) {
			throw new ValidateException("path does not exist.");
		}
		
		if(is_dir($validee) && $this->type==self::FILE) {
			throw new ValidateException("path is a directory, file expected.");
		}
		
		if(is_file($validee) && $this->type==self::DIR) {
			throw new ValidateException("path is a file, directory expected.");
		}

	}
}
