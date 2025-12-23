<?php
declare(strict_types=1);

namespace plibv4\validate;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Assert;

final class ValidatePathTest extends TestCase {
	public function testBothFile(): void {
		$validate = new ValidatePath(ValidatePath::BOTH);
		$this->assertEquals(NULL, $validate->validate(__DIR__."/ValidatePathTest.php"));
	}

	public function testBothDir(): void {
		$validate = new ValidatePath(ValidatePath::BOTH);
		$this->assertEquals(NULL, $validate->validate(__DIR__));
	}

	public function testFile(): void {
		$validate = new ValidatePath(ValidatePath::FILE);
		$this->assertEquals(NULL, $validate->validate(__DIR__."/ValidatePathTest.php"));
	}

	public function testDir(): void {
		$validate = new ValidatePath(ValidatePath::DIR);
		$this->assertEquals(NULL, $validate->validate(__DIR__));
	}

	public function testFileDir(): void {
		$validate = new ValidatePath(ValidatePath::FILE);
		$this->expectException(ValidateException::class);
		$this->assertEquals(NULL, $validate->validate(__DIR__));
	}

	public function testDirFile(): void {
		$validate = new ValidatePath(ValidatePath::DIR);
		$this->expectException(ValidateException::class);
		$this->assertEquals(NULL, $validate->validate(__DIR__."/ValidatePathTest.php"));
	}

	public function testPathDoesNotExist(): void {
		$validate = new ValidatePath(ValidatePath::FILE);
		$this->expectException(ValidateException::class);
		$this->assertEquals(NULL, $validate->validate(__DIR__."/ValidatePathTest.phpx"));
	}
	
	/**
	 * If an invalid format is rejected.
	 */
	public function testConstructInvalidFormat(): void {
		$this->expectException(InvalidArgumentException::class);
		$validate = new ValidatePath(-1);
	}
	
	
}
