<?php

namespace Tests\Unit;

use App\Helpers\Sanitizer;
use PHPUnit\Framework\TestCase;

class SanitizerTest extends TestCase
{
  public function test_clean_string_removes_html_tags(): void
  {
    $input = '<script>alert("xss")</script>Hello';
    $result = Sanitizer::cleanString($input);

    $this->assertStringNotContainsString('<script>', $result);
    $this->assertStringContainsString('Hello', $result);
  }

  public function test_clean_string_handles_null(): void
  {
    $this->assertEquals('', Sanitizer::cleanString(null));
  }

  public function test_clean_phone_removes_non_digits(): void
  {
    $phone = '+62 812-3456-7890';
    $result = Sanitizer::cleanPhone($phone);

    $this->assertEquals('081234567890', $result);
  }

  public function test_clean_phone_converts_62_to_0(): void
  {
    $phone = '628123456789';
    $result = Sanitizer::cleanPhone($phone);

    $this->assertStringStartsWith('0', $result);
  }

  public function test_clean_name_removes_special_characters(): void
  {
    $name = 'John123 Doe!@#';
    $result = Sanitizer::cleanName($name);

    $this->assertEquals('John Doe', $result);
  }

  public function test_clean_name_title_cases(): void
  {
    $name = 'JOHN DOE';
    $result = Sanitizer::cleanName($name);

    $this->assertEquals('John Doe', $result);
  }

  public function test_clean_int_respects_bounds(): void
  {
    $this->assertEquals(1, Sanitizer::cleanInt(-5, 1, 100));
    $this->assertEquals(100, Sanitizer::cleanInt(200, 1, 100));
    $this->assertEquals(50, Sanitizer::cleanInt(50, 1, 100));
  }

  public function test_clean_int_handles_string_input(): void
  {
    $this->assertEquals(42, Sanitizer::cleanInt('42'));
  }
}
