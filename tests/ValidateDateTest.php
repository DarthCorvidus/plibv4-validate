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
class ValidateDateTest extends TestCase {
	/**
	 * If an invalid format is rejected.
	 */
	public function testConstructInvalidFormat() {
		$this->expectException(InvalidArgumentException::class);
		$validate = new ValidateDate(-1);
	}
	/**
	 * If StringToArray is able to turn an ISO string into an Array.
	 */
	public function testStringToArrayIso() {
		$validate = new ValidateDate(ValidateDate::ISO);
		$reflector = new ReflectionClass("ValidateDate");
		$method = $reflector->getMethod("StringToArray");
		$method->setAccessible(true);
		$result = $method->invokeArgs($validate, array("2020-05-02"));
		$this->assertEquals(array("2020", "05", "02"), $result);
	}
	/**
	 * If StringToArray is able to turn a german date into an Array.
	 */
	public function testStringToArrayGerman() {
		$validate = new ValidateDate(ValidateDate::GERMAN);
		$reflector = new ReflectionClass("ValidateDate");
		$method = $reflector->getMethod("StringToArray");
		$method->setAccessible(true);
		$result = $method->invokeArgs($validate, array("02.05.2020"));
		$this->assertEquals(array("2020", "05", "02"), $result);
	}

	/**
	 * If StringToArray is able to turn a US date into an Array.
	 */
	public function testStringToArrayUs() {
		$validate = new ValidateDate(ValidateDate::US);
		$reflector = new ReflectionClass("ValidateDate");
		$method = $reflector->getMethod("StringToArray");
		$method->setAccessible(true);
		$result = $method->invokeArgs($validate, array("05/02/2020"));
		$this->assertEquals(array("2020", "05", "02"), $result);
	}

	public function testValidateSemantics() {
		$arrayDate = array("2020", "05", "02");
		$validate = new ValidateDate(ValidateDate::ISO);
		$reflector = new ReflectionClass("ValidateDate");
		$method = $reflector->getMethod("validateSemantics");
		$method->setAccessible(true);
		$result = $method->invokeArgs($validate, array($arrayDate));
		$this->assertEquals(NULL, $result);
	}

	public function testValidateSemanticsMonthZero() {
		$arrayDate = array("2020", "00", "02");
		$validate = new ValidateDate(ValidateDate::ISO);
		$reflector = new ReflectionClass("ValidateDate");
		$method = $reflector->getMethod("validateSemantics");
		$method->setAccessible(true);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_MONTH_OOR);
		$method->invokeArgs($validate, array($arrayDate));		
	}

	public function testValidateSemanticsMonthOutOfRange() {
		$arrayDate = array("2020", "13", "02");
		$validate = new ValidateDate(ValidateDate::ISO);
		$reflector = new ReflectionClass("ValidateDate");
		$method = $reflector->getMethod("validateSemantics");
		$method->setAccessible(true);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_MONTH_OOR);
		$method->invokeArgs($validate, array($arrayDate));		
	}
	
	public function testValidateSemanticsDayZero() {
		$arrayDate = array("2020", "05", "00");
		$validate = new ValidateDate(ValidateDate::ISO);
		$reflector = new ReflectionClass("ValidateDate");
		$method = $reflector->getMethod("validateSemantics");
		$method->setAccessible(true);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_DAY_OOR);
		$method->invokeArgs($validate, array($arrayDate));		
	}

	public function testValidateSemanticsDayOfRange() {
		$arrayDate = array("2020", "05", "32");
		$validate = new ValidateDate(ValidateDate::ISO);
		$reflector = new ReflectionClass("ValidateDate");
		$method = $reflector->getMethod("validateSemantics");
		$method->setAccessible(true);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_DAY_OOR);
		$method->invokeArgs($validate, array($arrayDate));		
	}

	public function testValidateSemanticsLeap() {
		$arrayDate = array("2020", "02", "29");
		$validate = new ValidateDate(ValidateDate::ISO);
		$reflector = new ReflectionClass("ValidateDate");
		$method = $reflector->getMethod("validateSemantics");
		$method->setAccessible(true);
		$result = $method->invokeArgs($validate, array($arrayDate));
		$this->assertEquals(NULL, $result);
	}

	public function testValidateSemanticsLeapWrong() {
		$arrayDate = array("2019", "02", "29");
		$validate = new ValidateDate(ValidateDate::ISO);
		$reflector = new ReflectionClass("ValidateDate");
		$method = $reflector->getMethod("validateSemantics");
		$method->setAccessible(true);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_DAY_OOR);
		$method->invokeArgs($validate, array($arrayDate));		
	}
	
	/**
	 * Validates "strict" date with leading zeroes
	 */
	public function testValidateIsoStrict() {
		$validate = new ValidateDate(ValidateDate::ISO);
		$this->assertEquals(NULL, $validate->validate("2020-05-02"));
	}

	/**
	 * Validates "sloppy" date without leading zeroes
	 */
	public function testValidateIsoSloppy() {
		$validate = new ValidateDate(ValidateDate::ISO);
		$this->assertEquals(NULL, $validate->validate("2020-5-2"));
	}

	/**
	 * Checks if "other" format (german) fails
	 */
	public function testValidateIsoGerman() {
		$time = new ValidateDate(ValidateDate::ISO);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$time->validate("05.02.2020");
	}

	/**
	 * Checks if "other" format (US) fails
	 */
	public function testValidateIsoUs() {
		$time = new ValidateDate(ValidateDate::ISO);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$time->validate("05/02/2020");
	}
	
	/**
	 * Checks if complete bogus input fails
	 */
	public function testValidateIsoBogus() {
		$time = new ValidateDate(ValidateDate::ISO);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$time->validate("Bogus");
	}

	/**
	 * Tests if year with bogus fails
	 */
	public function testValidateIsoBogusYear() {
		$time = new ValidateDate(ValidateDate::ISO);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$time->validate("2020a-05-02");
	}

	/**
	 * Tests if empty year fails 
	 */
	public function testValidateIsoEmptyYear() {
		$validate = new ValidateDate(ValidateDate::ISO);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$validate->validate("-05-02");
	}
	
	/**
	 * Tests if empty month fails
	 */
	public function testValidateIsoEmptyMonth() {
		$validate = new ValidateDate(ValidateDate::ISO);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$validate->validate("2020--02");
	}
	
	/**
	 * Tests if empty day fails
	 */
	public function testValidateIsoEmptyDay() {
		$validate = new ValidateDate(ValidateDate::ISO);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$validate->validate("2020-05-");
	}

	public function testValidateGermanStrict() {
		$validate = new ValidateDate(ValidateDate::GERMAN);
		$this->assertEquals(NULL, $validate->validate("02.05.2020"));
	}

	public function testValidateGermanSloppy() {
		$validate = new ValidateDate(ValidateDate::GERMAN);
		$this->assertEquals(NULL, $validate->validate("2.5.2020"));
	}

	public function testValidateGermanUs() {
		$time = new ValidateDate(ValidateDate::GERMAN);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$time->validate("05/02/2020");
	}

	public function testValidateGermanIso() {
		$time = new ValidateDate(ValidateDate::GERMAN);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$time->validate("2020-05-02");
	}

	public function testValidateGermanBogus() {
		$time = new ValidateDate(ValidateDate::GERMAN);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$time->validate("Bogus");
	}

	public function testValidateGermanBogusYear() {
		$time = new ValidateDate(ValidateDate::GERMAN);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$time->validate("2020a-05-02");
	}

	public function testValidateGermanEmptyYear() {
		$validate = new ValidateDate(ValidateDate::GERMAN);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$validate->validate("02.05.");
	}

	public function testValidateGermanEmptyMonth() {
		$validate = new ValidateDate(ValidateDate::GERMAN);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$validate->validate("02..2020");
	}

	public function testValidateGermanEmptyDay() {
		$validate = new ValidateDate(ValidateDate::GERMAN);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$validate->validate(".05.2020");
	}

	public function testValidateUsStrict() {
		$validate = new ValidateDate(ValidateDate::US);
		$this->assertEquals(NULL, $validate->validate("05/02/2020"));
	}

	public function testValidateUsSloppy() {
		$validate = new ValidateDate(ValidateDate::US);
		$this->assertEquals(NULL, $validate->validate("5/2/2020"));
	}

	public function testValidateUsGerman() {
		$time = new ValidateDate(ValidateDate::US);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$time->validate("02.05.2020");
	}

	public function testValidateUsIso() {
		$time = new ValidateDate(ValidateDate::US);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$time->validate("2020-05-02");
	}

	
	public function testValidateUsBogus() {
		$time = new ValidateDate(ValidateDate::US);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$time->validate("Bogus");
	}
	
	public function testValidateUsBogusYear() {
		$time = new ValidateDate(ValidateDate::US);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$time->validate("05/02/2020a");
	}

	public function testValidateUsEmptyYear() {
		$validate = new ValidateDate(ValidateDate::US);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$validate->validate("05/02/");
	}

	public function testValidateUsEmptyMonth() {
		$validate = new ValidateDate(ValidateDate::US);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$validate->validate("/02/2020");
	}

	public function testValidateUsEmptyDay() {
		$validate = new ValidateDate(ValidateDate::US);
		$this->expectException(ValidateException::class);
		$this->expectExceptionCode(ValidateDateException::VD_SYNTAX);
		$validate->validate("05//2020");
	}
}
