<?php
declare(strict_types=1);

namespace plibv4\validate;
use PHPUnit\Framework\TestCase;

/**
 * Unit Test for ValidateMinMax
 * 
 * @author Claus-Christoph Kuethe
 * @copyright (c) 2023, Claus-Christoph Kuethe
 */
final class ValidateMinMaxStringTest extends TestCase {
	function testConstruct(): void {
		$validate = new ValidateMinMaxString(4, 15);
		$this->assertInstanceOf(ValidateMinMaxString::class, $validate);
	}
	
	function testValidate(): void {
		$validate = new ValidateMinMaxString(4, 15);
		$this->assertEquals(NULL, $validate->validate("Imperius"));
	}
	
	function testValidateShortest(): void {
		$validate = new ValidateMinMaxString(4, 15);
		$this->assertEquals(NULL, $validate->validate("John"));
	}
	
	function testValidateTooShort(): void {
		$validate = new ValidateMinMaxString(4, 15);
		$this->expectException(ValidateException::class);
		$this->expectExceptionMessage("value too short, min 4 characters.");
		$validate->validate("Joe");
	}
	
	function testValidateLongest(): void {
		$validate = new ValidateMinMaxString(4, 15);
		$this->assertEquals(NULL, $validate->validate("ImperiusMaximus"));
	}

	function testValidateTooLong(): void {
		$validate = new ValidateMinMaxString(4, 15);
		$this->expectException(ValidateException::class);
		$this->expectExceptionMessage("value too long, max 15 characters.");
		$validate->validate("GaiusIuliusCaesar");
	}

	function testValidateMultibyteMin(): void {
		$validate = new ValidateMinMaxString(5, 7);
		$this->assertEquals(NULL, $validate->validate("Lügen"));
		$this->expectExceptionMessage("value too short, min 5 characters.");
		$validate->validate("Lüge");
	}
	
	function testValidateMultibyteMax(): void {
		$validate = new ValidateMinMaxString(3, 7);
		$this->assertEquals(NULL, $validate->validate("München"));
	}
}
