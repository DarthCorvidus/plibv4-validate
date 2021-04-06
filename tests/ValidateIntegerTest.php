<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ValidateDateTest
 *
 * @author hm
 */
class ValidateIntegerTest extends TestCase {
	function testInteger() {
		$validate = new ValidateInteger();
		$this->assertEquals(NULL, $validate->validate("15"));
	}

	function testFloat() {
		$validate = new ValidateInteger();
		$this->expectException(ValidateException::class);
		$this->expectExceptionMessage("not a valid integer");
		$validate->validate("19.14");
	}

	function testCastableFloat() {
		$validate = new ValidateInteger();
		$this->expectException(ValidateException::class);
		$this->expectExceptionMessage("not a valid integer");
		$validate->validate("19.0");
	}
	
	function testBogus() {
		$validate = new ValidateInteger();
		$this->expectException(ValidateException::class);
		$this->expectExceptionMessage("not a valid integer");
		$validate->validate("Fifteen");
	}
	
	function testMixedBogus() {
		$validate = new ValidateInteger();
		$this->expectException(ValidateException::class);
		$this->expectExceptionMessage("not a valid integer");
		$validate->validate("15 dogs");
	}

}
