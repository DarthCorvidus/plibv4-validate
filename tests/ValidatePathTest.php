<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
class ValidatePathTest extends TestCase {
	public function testBothFile() {
		$validate = new ValidatePath(ValidatePath::BOTH);
		$this->assertEquals(NULL, $validate->validate(__DIR__."/ValidatePathTest.php"));
	}

	public function testBothDir() {
		$validate = new ValidatePath(ValidatePath::BOTH);
		$this->assertEquals(NULL, $validate->validate(__DIR__));
	}

	public function testFile() {
		$validate = new ValidatePath(ValidatePath::FILE);
		$this->assertEquals(NULL, $validate->validate(__DIR__."/ValidatePathTest.php"));
	}

	public function testDir() {
		$validate = new ValidatePath(ValidatePath::DIR);
		$this->assertEquals(NULL, $validate->validate(__DIR__));
	}

	public function testFileDir() {
		$validate = new ValidatePath(ValidatePath::FILE);
		$this->expectException(ValidateException::class);
		$this->assertEquals(NULL, $validate->validate(__DIR__));
	}

	public function testDirFile() {
		$validate = new ValidatePath(ValidatePath::DIR);
		$this->expectException(ValidateException::class);
		$this->assertEquals(NULL, $validate->validate(__DIR__."/ValidatePathTest.php"));
	}

	/**
	 * If an invalid format is rejected.
	 */
	public function testConstructInvalidFormat() {
		$this->expectException(InvalidArgumentException::class);
		$validate = new ValidatePath(-1);
	}
	
	
}
