<?php
namespace plibv4\validate;
/**
 * ValidateArray
 * 
 * Supposed to validate arrays, targeted to work in conjunction with Import and
 * Argv, to have a validation over all values. An example could be to check two
 * options which are allowed on their own but are mutually exclusive.
 */
interface ValidateArray {
	/**
	 * Implementation is supposed to validate an array. ValidateArray must not
	 * have a return value; if validation fails, a ValidateException has to be
	 * thrown.
	 * @param array $validee
	 * @throws ValidateException
	 */
	function validateArray(array $validee): void;
}