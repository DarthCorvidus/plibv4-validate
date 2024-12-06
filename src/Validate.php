<?php

/**
 * Validate is an interface for a class that is supposed to validate strings,
 * which come from user input or other sources like command line arguments,
 * GET or POST parameters etc.
 */
interface Validate {
	/**
	 * Implementation is supposed to validate a string. Validate must not have
	 * a return value; if validation fails, a ValidateException has to be thrown.
	 * @param string $validee
	 * @return void
	 * @throws ValidateException
	 */
	function validate(string $validee): void;
}