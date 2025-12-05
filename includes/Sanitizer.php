<?php

namespace Giganteck\Opton;

use Giganteck\Opton\Contracts\SanitizerInterface;
use Giganteck\Opton\Sanitizers\Email;
use Giganteck\Opton\Sanitizers\Url;
use Giganteck\Opton\Sanitizers\Textarea;
use Giganteck\Opton\Sanitizers\Html;
use Giganteck\Opton\Sanitizers\Phone;
use Giganteck\Opton\Sanitizers\Date;
use Giganteck\Opton\Sanitizers\Json;
use Giganteck\Opton\Sanitizers\StripTags;
use Giganteck\Opton\Sanitizers\Text;

/**
 * Factory for creating sanitizers
 */
class Sanitizer
{
    private static $sanitizers = [];
    private static $customSanitizers = [];

    /**
     * Get sanitizer instance
     *
     * @param string $type Sanitizer type
     * @return SanitizerInterface
     */
    public static function getSanitizer(string $type): SanitizerInterface
    {
        // Check for custom sanitizer first
        if (isset(self::$customSanitizers[$type])) {
            return self::$customSanitizers[$type];
        }

        // Return cached sanitizer if exists
        if (isset(self::$sanitizers[$type])) {
            return self::$sanitizers[$type];
        }

        // Create and cache sanitizer
        $sanitizer = self::createSanitizer($type);
        self::$sanitizers[$type] = $sanitizer;

        return $sanitizer;
    }

    /**
     * Create sanitizer instance
     *
     * @param string $type Sanitizer type
     * @return SanitizerInterface
     */
    private static function createSanitizer(string $type): SanitizerInterface
    {
        switch ($type) {
            case 'email':
                return new Email();

            case 'url':
                return new Url();

            case 'textarea':
                return new Textarea();

            case 'html':
                return new Html();

            case 'phone':
                return new Phone();

            case 'date':
                return new Date();

            case 'json':
                return new Json();

            case 'striptags':
                return new StripTags();

            case 'text':
            default:
                return new Text();
        }
    }

    /**
     * Register a custom sanitizer
     *
     * @param string $type Sanitizer type
     * @param SanitizerInterface $sanitizer Sanitizer instance
     * @return void
     */
    public static function registerSanitizer(string $type, SanitizerInterface $sanitizer): void
    {
        self::$customSanitizers[$type] = $sanitizer;
    }

    /**
     * Clear all cached sanitizers for testing
     *
     * @return void
     */
    public static function clearCache(): void
    {
        self::$sanitizers = [];
    }
}
