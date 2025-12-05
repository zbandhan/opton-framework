<?php

namespace Giganteck\Opton;

use Giganteck\Opton\Utils\Template;

/**
 * Form class for managing pages and sections
 */
class Form
{
    private $pages = [];
    private $currentPage = '';
    private $theme = 'default';
    private $cachedSections = null;

    /**
     * Add page for setting and metabox
     *
     * @param string $pageId
     * @param callable $callback
     * @return static
     */
    public function page(string $pageId, callable $callback): self
    {
        $this->currentPage = $pageId;

        if (!isset($this->pages[$pageId])) {
            $this->pages[$pageId] = [];
        }

        // Capture sections
        $sectionBuilder = new SectionBuilder($this, $pageId);
        $callback($sectionBuilder);

        return $this;
    }

    /**
     * Add section for fields
     *
     * @param string $pageId
     * @param Section $section
     * @return void
     */
    public function addSection(string $pageId, Section $section): void
    {
        $this->pages[$pageId][] = $section;
    }

    /**
     * Get all pages
     *
     * @return array
     */
    public function getPages(): array
    {
        return $this->pages;
    }

    /**
     * Get all fields as array
     *
     * @return array
     */
    public function getAllFields(): array
    {
        $allFields = [];

        foreach ($this->pages as $sections) {
            foreach ($sections as $section) {
                $fields = $section->getFields();

                if ($section->isRepeaterSection()) {
                    $allFields = array_merge($allFields, $fields);
                } else {
                    $allFields = array_merge($allFields, $fields);
                }
            }
        }

        return $allFields;
    }

    /**
     * Set the theme for this form
     *
     * @param string $theme Theme name (default, modern, elegant, etc.)
     * @return self
     */
    public function setTheme(string $theme): self
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * Get the current theme
     *
     * @return string
     */
    public function getTheme(): string
    {
        return $this->theme;
    }

    /**
     * Get sections
     *
     * @return mixed
     */
    public function getSections()
    {
        if ($this->cachedSections === null) {
            $this->cachedSections = [];

            foreach ($this->pages as $sections) {
                $this->cachedSections = array_merge($this->cachedSections, $sections);
            }
        }

        return $this->cachedSections;
    }

    /**
     * Render tabs and pages
     *
     * @param mixed $menus
     * @param int $postId
     * @param array $options
     * @param null|string $optionName
     * @return string
     */
    public function render($menus, $postId = null, $options = [], $optionName = null)
    {
        $html = '';

        // Render tab navigation if multiple pages
        if (count($this->pages) > 1 && $menus) {
            $html .= Template::get_view('form/tabs-navigation', ['menus' => $menus], $this->theme);
        }

        // Render page contents
        $pages_parts = [];
        $first = true;

        foreach ($this->pages as $pageId => $sections) {
            $section_parts = [];

            foreach ($sections as $section) {
                $section_parts[] = $section->render($postId, $options, $optionName);
            }

            $pages_parts[] = Template::get_view('form/page', [
                'page_id' => $pageId,
                'is_first' => $first,
                'content' => implode('', $section_parts)
            ], $this->theme);

            $first = false;
        }

        $html .= Template::get_view('form/pages-wrapper', ['content' => implode('', $pages_parts)], $this->theme);

        return $html;
    }

}
