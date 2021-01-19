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
	/**
	 * If an invalid limit is rejected
	 */
	public function testConstructInvalidFormat() {
		$this->expectException(InvalidArgumentException::class);
		$validate = new ValidateTime(-1);
	}
	/**
	 * If 'strict' time with leading zeroes valid
	 */
	public function testValidateStrict() {
		$validate = new ValidateTime();
		$this->assertEquals(NULL, $validate->validate("05:37:01"));
	}
	
	/**
	 * If 'sloppy' time without leading zeroes valid
	 */
	public function testValidateSloppy() {
		$validate = new ValidateTime();
		$this->assertEquals(NULL, $validate->validate("5:37:1"));
	}

	/**
	 * If time without seconds is valid
	 */
	public function testValidateHoursMinutes() {
		$validate = new ValidateTime();
		$this->assertEquals(NULL, $validate->validate("05:37"));

	}

	/**
	 * If time without minutes is valid
	 */
	public function testValidateHours() {
		$validate = new ValidateTime();
		$this->assertEquals(NULL, $validate->validate("05"));
	}

	/**
	 * If complete bogus is rejected
	 */
	public function testBogus() {
		$time = new ValidateTime();
		$this->expectException(ValidateException::class);
		$time->validate("Bogus");
	}

	/**
	 * If empty hours (:MM:SS) are rejected
	 */
	public function testEmptyHours() {
		$time = new ValidateTime();
		$this->expectException(ValidateException::class);
		$time->validate(":47:30");
	}

	/**
	 * If empty minutes are rejected (HH::SS)
	 */
	public function testEmptyMinutes() {
		$time = new ValidateTime();
		$this->expectException(ValidateException::class);
		$time->validate("07::30");
	}

	/**
	 * If empty seconds are rejected (HH:MM:)
	 */
	public function testEmptySeconds() {
		$time = new ValidateTime();
		$this->expectException(ValidateException::class);
		$time->validate("07:47:");
	}
	
	/**
	 * If out of range hours are rejected (only if limit is set to 
	 * ValidateTime::DAY)
	 */
	public function testHoursOutOfRange() {
		$validate = new ValidateTime(ValidateTime::DAY);
		$this->expectException(ValidateException::class);
		$validate->validate("25");
	}

	/**
	 * If out of range hours are allowed (only if limit is set to 
	 * ValidateTime::UNLIMITED)
	 */
	public function testHoursUnlimited() {
		$validate = new ValidateTime(ValidateTime::UNLIMITED);
		$this->assertEquals(NULL, $validate->validate("125:02:47"));
	}

	/**
	 * If out of range minutes are rejected (always)
	 */
	public function testMinutesOutOfRange() {
		$validate = new ValidateTime();
		$this->expectException(ValidateException::class);
		$validate->validate("22:60");
	}

	/**
	 * If out of range seconds are rejected (always)
	 */
	public function testSecondsOutOfRange() {
		$validate = new ValidateTime();
		$this->expectException(ValidateException::class);
		$validate->validate("22:39:72");
	}
	
	/**
	 * If too many segments are rejected (??:HH:MM:SS)
	 */
	public function testTooMany() {
		$validate = new ValidateTime();
		$this->expectException(ValidateException::class);
		$validate->validate("17:22:39:72");
	}

	
}
