<?php

namespace Giganteck\Opton\Abstracts;

use Giganteck\Opton\Utils\Template;

/**
 * Abstract Setting class for creating option pages
 */
abstract class Setting extends FormProcessor
{

    public function __construct()
    {
        add_action('admin_menu', [$this, 'addSettingsPage']);
        add_action('admin_init', [$this, 'registerSettings']);
    }

    abstract protected function pageTitle(): string;
    abstract protected function menuTitle(): string;
    abstract protected function capability(): string;
    abstract protected function menuSlug(): string;

    /**
     * Get the theme for this settings page
     * Override this method to use a different theme
     *
     * @return string Theme name (default, modern, elegant, etc.)
     */
    protected function theme(): string
    {
        return 'default';
    }

    protected function optionGroup(): string
    {
        return $this->menuSlug() . '_group';
    }

    protected function optionName(): string
    {
        return $this->menuSlug() . '_option';
    }

    protected function parentSlug(): ?string
    {
        return null;
    }

    protected function icon(): string
    {
        return 'dashicons-admin-generic';
    }

    protected function position(): ?int
    {
        return null;
    }

    protected function menus(): ?array
    {
        return null;
    }

    protected function description(): string
    {
        return '';
    }

    public function addSettingsPage()
    {
        if ($this->parentSlug()) {
            add_submenu_page(
                $this->parentSlug(),
                $this->pageTitle(),
                $this->menuTitle(),
                $this->capability(),
                $this->menuSlug(),
                [$this, 'renderSettingsPage']
            );
        } else {
            add_menu_page(
                $this->pageTitle(),
                $this->menuTitle(),
                $this->capability(),
                $this->menuSlug(),
                [$this, 'renderSettingsPage'],
                $this->icon(),
                $this->position()
            );
        }
    }

    /**
     * Register setting field
     *
     * @return void
     */
    public function registerSettings()
    {
        register_setting(
            $this->optionGroup(),
            $this->optionName(),
            [
                'sanitize_callback' => [$this, 'sanitizeSettings']
            ]
        );
    }

    /**
     * Render setting page with data style and script
     *
     * @return void
     */
    public function renderSettingsPage()
    {
        wp_enqueue_style('opton-style');
        wp_enqueue_script('opton-script');

        // Show validation errors if any
        $errors = get_transient('opton_validation_errors_' . get_current_user_id());
        if ($errors) {
            Template::view('settings/errors', ['errors' => $errors], $this->theme());
            delete_transient('opton_validation_errors_' . get_current_user_id());
        }

        // Show success message if settings were saved
        if (isset($_GET['settings-updated']) && sanitize_text_field(wp_unslash($_GET['settings-updated']))) {
            Template::view('settings/success', [], $this->theme());
        }

        // Get saved options
        $options = get_option($this->optionName(), []);

        // Create and render form
        $this->form = $this->initializeForm();

        // Render settings page wrapper
        Template::view('settings/page-wrapper', [
            'page_title' => $this->pageTitle(),
            'description' => $this->description(),
            'option_group' => $this->optionGroup(),
            'option_name' => $this->optionName(),
            'menu_slug' => $this->menuSlug(),
            'menus' => $this->menus(),
            'form_html' => $this->form->render($this->menus(), null, $options, $this->optionName())
        ], $this->theme());
    }

    public function sanitizeSettings($input)
    {
        if (!check_admin_referer($this->optionGroup() . '-options')) {
            return get_option($this->optionName(), []);
        }

        // Recreate form to get all fields
        $this->form = $this->initializeForm();

        // Get all sections
        $sections = $this->form->getSections();

        // Process form data using FormProcessor
        $result = $this->processFormData($sections, $input);

        // Store errors if any
        if (!empty($result['errors'])) {
            $this->storeErrors(get_current_user_id(), $result['errors']);
            add_settings_error(
                $this->optionName(),
                'validation_error',
                'There were validation errors. Please check the form.',
                'error'
            );
        }

        return $result['sanitized'];
    }

    /**
     * Save sanitized data to options
     * Note: For settings, WordPress handles the actual save via register_setting()
     * We return the data from sanitizeSettings() instead
     *
     * @param string $option_name Option name (not used, kept for interface compliance)
     * @param array $sanitizedData Sanitized field data
     * @return void
     */
    protected function saveData($option_name, array $sanitizedData): void
    {
        // Not used for settings - WordPress Settings API handles this
        // Data is returned from sanitizeSettings() callback
    }

    /**
     * Store validation errors in transient
     *
     * @param int $user_id User ID
     * @param array $errors Validation errors
     * @return void
     */
    protected function storeErrors($user_id, array $errors): void
    {
        set_transient('opton_validation_errors_' . $user_id, $errors, 30);
    }
}
