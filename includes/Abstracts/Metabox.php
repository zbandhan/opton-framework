<?php

namespace Giganteck\Opton\Abstracts;

use Giganteck\Opton\Utils\Template;

/**
 * Abstract Metabox class to be extended
 */
abstract class Metabox extends FormProcessor
{

    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'addMetaBox']);
        add_action('save_post', [$this, 'saveMetaBox']);
    }

    abstract protected function id(): string;
    abstract protected function title(): string;
    abstract protected function screen(): string|array;

    /**
     * Get the theme for this metabox
     * Override this method to use a different theme
     *
     * @return string Theme name (default, modern, elegant, etc.)
     */
    protected function theme(): string
    {
        return 'default';
    }

    protected function pageTitle(): string
    {
        return '';
    }

    protected function menus(): ?array
    {
        return null;
    }

    protected function context(): string
    {
        return 'normal';
    }

    protected function priority(): string
    {
        return 'default';
    }

    /**
     * Register metabox with add_meta_boxes hook
     *
     * @return void
     */
    public function addMetaBox()
    {
        add_meta_box(
            $this->id(),
            $this->title(),
            [$this, 'renderMetaBox'],
            $this->screen(),
            $this->context(),
            $this->priority()
        );
    }

    /**
     * Render input fields in registered metabox area
     *
     * @param mixed $post
     * @return void
     */
    public function renderMetaBox($post)
    {
        wp_enqueue_style('opton-style');
        wp_enqueue_script('opton-script');
        wp_nonce_field($this->id() . '_save', $this->id() . '_nonce');

        // Show validation errors if any
        $errors = get_transient('opton_validation_errors_' . $post->ID);
        if ($errors) {
            Template::view('metabox/errors', ['errors' => $errors], $this->theme());
            delete_transient('opton_validation_errors_' . $post->ID);
        }

        // Create and render form
        $this->form = $this->initializeForm();

        // Render metabox page wrapper
        Template::view('metabox/page-wrapper', [
            'page_title' => $this->pageTitle(),
            'form_html' => $this->form->render($this->menus(), $post->ID)
        ], $this->theme());
    }

    /**
     * Save metabox fields value
     *
     * @param mixed $post_id
     * @return void
     */
    public function saveMetaBox($post_id)
    {
        // Verify nonce
        $nonce = isset($_POST[$this->id() . '_nonce']) ? sanitize_text_field(wp_unslash($_POST[$this->id() . '_nonce'])) : '';
        if (empty($nonce) || !wp_verify_nonce($nonce, $this->id() . '_save')) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Recreate form to get all fields
        $this->form = $this->initializeForm();

        // Get all sections
        $sections = $this->form->getSections();

        // Process form data using FormProcessor
        $result = $this->processFormData($sections, $_POST);

        // Save sanitized data
        $this->saveData($post_id, $result['sanitized']);

        // Store errors if any
        if (!empty($result['errors'])) {
            $this->storeErrors($post_id, $result['errors']);
        }
    }

    /**
     * Save sanitized data to post meta
     *
     * @param int $post_id Post ID
     * @param array $sanitizedData Sanitized field data
     * @return void
     */
    protected function saveData($post_id, array $sanitizedData): void
    {
        foreach ($sanitizedData as $fieldName => $value) {
            update_post_meta($post_id, $fieldName, $value);
        }
    }

    /**
     * Store validation errors in transient
     *
     * @param int $post_id Post ID
     * @param array $errors Validation errors
     * @return void
     */
    protected function storeErrors($post_id, array $errors): void
    {
        set_transient('opton_validation_errors_' . $post_id, $errors, 30);
    }

}
