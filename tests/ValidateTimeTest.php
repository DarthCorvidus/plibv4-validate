<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ValidateTimeTest
 *
 * @author hm
 */
class ValidateTimeTest extends TestCase {
	public function testValidateStrict() {
		$validate = new ValidateTime();
		$this->assertEquals(NULL, $validate->validate("05:37:01"));
	}
	
	public function testValidateSloppy() {
		$validate = new ValidateTime();
		$this->assertEquals(NULL, $validate->validate("5:37:1"));
	}

	public function testValidateHoursMinutes() {
		$validate = new ValidateTime();
		$this->assertEquals(NULL, $validate->validate("05:37"));

	}

	public function testValidateHours() {
		$validate = new ValidateTime();
		$this->assertEquals(NULL, $validate->validate("05"));
	}

	public function testBogus() {
		$time = new ValidateTime();
		$this->expectException(ValidateException::class);
		$time->validate("Bogus");
	}

	public function testEmptyHours() {
		$time = new ValidateTime();
		$this->expectException(ValidateException::class);
		$time->validate(":47:30");
	}

	public function testEmptyMinutes() {
		$time = new ValidateTime();
		$this->expectException(ValidateException::class);
		$time->validate("07::30");
	}

	public function testEmptySeconds() {
		$time = new ValidateTime();
		$this->expectException(ValidateException::class);
		$time->validate("07:47:");
	}
	
	public function testHoursOutOfRange() {
		$validate = new ValidateTime(ValidateTime::DAY);
		$this->expectException(ValidateException::class);
		$validate->validate("25");
	}

	public function testHoursUnlimited() {
		$validate = new ValidateTime(ValidateTime::UNLIMITED);
		$this->assertEquals(NULL, $validate->validate("125:02:47"));
	}

	
	public function testMinutesOutOfRange() {
		$validate = new ValidateTime();
		$this->expectException(ValidateException::class);
		$validate->validate("22:60");
	}

	public function testSecondsOutOfRange() {
		$validate = new ValidateTime();
		$this->expectException(ValidateException::class);
		$validate->validate("22:39:72");
	}
	
}
