<?php
declare(strict_types=1);
namespace plibv4\validate;

use PHPUnit\Framework\TestCase;
/**
 * Unit Test for ValidateEnum
 * 
 * @author Claus-Christoph Kuethe
 * @copyright (c) 2023, Claus-Christoph Kuethe
 */
class ValidateEnumTest extends TestCase {
	function testConstruct() {
		$validate = new ValidateEnum(array("Hund", "Katze", "Maus"));
		$this->assertInstanceOf(ValidateEnum::class, $validate);
	}
	
	function testValidateEnumAllowed() {
		$validate = new ValidateEnum(array("Hund", "Katze", "Maus"));
		$this->assertEquals(NULL, $validate->validate("Hund"));
		$this->assertEquals(NULL, $validate->validate("Katze"));
		$this->assertEquals(NULL, $validate->validate("Maus"));
	}
	
	function testValidateEnumDisallowed() {
		$validate = new ValidateEnum(array("Hund", "Katze", "Maus"));
		$this->expectException(ValidateException::class);
		$this->expectExceptionMessage("Value 'Aaskrähe' not in allowed set {Hund,Katze,Maus}");
		$validate->validate("Aaskrähe");
	}
}
