<?php

namespace Giganteck\Opton\Utils;

/**
 * Template loader utility
 */
class Template {
    /**
     * Load a template file from the view directory
     *
     * @param string $slug Template slug (relative to view directory)
     * @param array $args Arguments to pass to the template
     * @param string $theme Theme name (default, modern, elegant, etc.)
     * @return void
     */
    public static function view( string $slug, array $args = [], string $theme = 'default' ): void {
        $template_file = OPTON_FRAMEWORK_DIR . "/view/{$theme}/{$slug}.php";

        // Fallback to default theme if not found
        if ( !file_exists( $template_file ) ) {
            $template_file = OPTON_FRAMEWORK_DIR . "/view/default/{$slug}.php";
        }

        if ( file_exists( $template_file ) ) {
            load_template( $template_file, false, $args );
        } else {
            echo esc_html( "Template not found: {$slug}.php in theme '{$theme}' or 'default'" );
        }
    }

    /**
     * Get rendered template as string
     *
     * @param string $slug Template slug (relative to view directory)
     * @param array $args Arguments to pass to the template
     * @param string $theme Theme name
     * @return string
     */
    public static function get_view( string $slug, array $args = [], string $theme = 'default' ): string {
        ob_start();
        self::view( $slug, $args, $theme );
        return ob_get_clean();
    }
}
