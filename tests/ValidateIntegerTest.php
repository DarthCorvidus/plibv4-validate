<?php
/**
 * @copyright (c) 2023, Claus-Christoph Küthe
 * @author Claus-Christoph Küthe <floss@vm01.telton.de>
 * @license LGPL
 */
declare(strict_types=1);

namespace plibv4\validate;
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
final class ValidateIntegerTest extends TestCase {
	function testInteger(): void {
		$validate = new ValidateInteger();
		$this->assertEquals(null, $validate->validate("15"));
		$this->assertEquals(null, $validate->validate("-15"));
	}

	function testNegativeInteger(): void {
		$validate = new ValidateInteger();
		$this->assertEquals(null, $validate->validate("-15"));
	}

	function testOnlyPositive(): void {
		$validate = new ValidateInteger(false);
		$this->expectExceptionMessage("not a valid positive integer");
		$this->assertEquals(null, $validate->validate("-15"));
	}

	function testEmpty(): void {
		$validate = new ValidateInteger(false);
		$this->expectExceptionMessage("not a valid positive integer");
		$this->assertEquals(null, $validate->validate(""));
	}

	function testEmptyNegative(): void {
		$validate = new ValidateInteger(true);
		$this->expectExceptionMessage("not a valid integer");
		$this->assertEquals(null, $validate->validate("-"));
	}

	function testFloat(): void {
		$validate = new ValidateInteger();
		$this->expectException(ValidateException::class);
		$this->expectExceptionMessage("not a valid integer");
		$validate->validate("19.14");
	}

	function testCastableFloat(): void {
		$validate = new ValidateInteger();
		$this->expectException(ValidateException::class);
		$this->expectExceptionMessage("not a valid integer");
		$validate->validate("19.0");
	}
	
	function testBogus(): void {
		$validate = new ValidateInteger();
		$this->expectException(ValidateException::class);
		$this->expectExceptionMessage("not a valid integer");
		$validate->validate("Fifteen");
	}
	
	function testMixedBogus(): void {
		$validate = new ValidateInteger();
		$this->expectException(ValidateException::class);
		$this->expectExceptionMessage("not a valid integer");
		$validate->validate("15 dogs");
	}

}
