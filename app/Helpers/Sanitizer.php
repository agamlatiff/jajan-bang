<?php

namespace App\Helpers;

class Sanitizer
{
  /**
   * Sanitize a string for safe display
   */
  public static function cleanString(?string $input): string
  {
    if (empty($input)) {
      return '';
    }

    // Remove HTML tags
    $clean = strip_tags($input);

    // Convert special characters to HTML entities
    $clean = htmlspecialchars($clean, ENT_QUOTES, 'UTF-8');

    // Remove any null bytes
    $clean = str_replace("\0", '', $clean);

    // Trim whitespace
    $clean = trim($clean);

    return $clean;
  }

  /**
   * Sanitize a phone number (Indonesian format)
   */
  public static function cleanPhone(?string $phone): string
  {
    if (empty($phone)) {
      return '';
    }

    // Remove all non-digit characters
    $clean = preg_replace('/[^0-9]/', '', $phone);

    // Convert +62 to 0 if present
    if (str_starts_with($clean, '62')) {
      $clean = '0' . substr($clean, 2);
    }

    return $clean;
  }

  /**
   * Sanitize a name (letters and spaces only)
   */
  public static function cleanName(?string $name): string
  {
    if (empty($name)) {
      return '';
    }

    // Remove anything that's not a letter or space
    $clean = preg_replace('/[^a-zA-Z\s]/', '', $name);

    // Remove multiple spaces
    $clean = preg_replace('/\s+/', ' ', $clean);

    // Trim and title case
    $clean = ucwords(trim(strtolower($clean)));

    return $clean;
  }

  /**
   * Sanitize an integer value
   */
  public static function cleanInt($value, int $min = 0, int $max = PHP_INT_MAX): int
  {
    $clean = (int) $value;
    return max($min, min($max, $clean));
  }
}
