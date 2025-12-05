<?php

namespace Giganteck\Opton;

use Giganteck\Opton\Contracts\RendererInterface;
use Giganteck\Opton\FieldRenderers\Text;
use Giganteck\Opton\FieldRenderers\Checkbox;
use Giganteck\Opton\FieldRenderers\Radio;
use Giganteck\Opton\FieldRenderers\Textarea;
use Giganteck\Opton\FieldRenderers\Select;
use Giganteck\Opton\FieldRenderers\Date;
use Giganteck\Opton\FieldRenderers\Color;
use Giganteck\Opton\FieldRenderers\File;

/**
 * Factory for creating field renderers
 */
class Renderer
{
    private static $renderers = [];
    private static $customRenderers = [];

    /**
     * Get renderer for a specific field type
     *
     * @param string $type Field type
     * @return RendererInterface
     */
    public static function getRenderer(string $type): RendererInterface
    {
        // Check for custom renderer first
        if (isset(self::$customRenderers[$type])) {
            return self::$customRenderers[$type];
        }

        // Return cached renderer if exists
        if (isset(self::$renderers[$type])) {
            return self::$renderers[$type];
        }

        // Create and cache renderer
        $renderer = self::createRenderer($type);
        self::$renderers[$type] = $renderer;

        return $renderer;
    }

    /**
     * Create renderer instance for field type
     *
     * @param string $type Field type
     * @return RendererInterface
     */
    private static function createRenderer(string $type): RendererInterface
    {
        switch ($type) {
            case 'text':
                return new Text();

            case 'checkbox':
                return new Checkbox();

            case 'radio':
                return new Radio();

            case 'textarea':
                return new Textarea();

            case 'select':
                return new Select();

            case 'date':
                return new Date();

            case 'color':
                return new Color();

            case 'file':
                return new File();

            default:
                return new Text();
        }
    }

    /**
     * Register a custom field renderer
     *
     * @param string $type Field type
     * @param RendererInterface $renderer Renderer instance
     * @return void
     */
    public static function registerRenderer(string $type, RendererInterface $renderer): void
    {
        self::$customRenderers[$type] = $renderer;
    }

    /**
     * Clear all cached renderers (useful for testing)
     *
     * @return void
     */
    public static function clearCache(): void
    {
        self::$renderers = [];
    }
}
