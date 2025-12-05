<?php

namespace Giganteck\Opton;

class Assets {
    public function register() {
        add_action('wp_enqueue_scripts', [$this, 'opton_enqueue_assets']);
        add_action('admin_enqueue_scripts', [$this, 'opton_enqueue_assets']);
    }

    public function opton_enqueue_assets() {
        wp_register_style('opton-style', plugins_url('assets/css/style.css', __DIR__), [], OPTON_FRAMEWORK_VERSION);
        wp_register_script('opton-script', plugins_url('assets/js/scripts.js', __DIR__), ['jquery'], OPTON_FRAMEWORK_VERSION, true);
    }
}
