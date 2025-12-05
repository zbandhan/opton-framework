<?php

namespace Giganteck\Opton;

/**
 * Create a section builder class that captures sections
 */
class SectionBuilder
{
    private $form;
    private $pageId;

    public function __construct($form, $pageId)
    {
        $this->form = $form;
        $this->pageId = $pageId;
    }

    public function __invoke(string $title = '')
    {
        $section = new Section();
        $section->setTheme($this->form->getTheme());

        if ($title) {
            $section->title($title);
        }

        $this->form->addSection($this->pageId, $section);

        return $section;
    }
}
