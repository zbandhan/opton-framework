<?php
/**
 * Template for displaying metabox validation errors
 *
 * @var array $args['errors'] Array of validation errors
 */
defined('ABSPATH') || exit;

$optonErrors = $args['errors'] ?? [];

if (!empty($optonErrors)) : ?>
    <div class="notice notice-error">
        <ul>
            <?php foreach ($optonErrors as $optonFieldErrors) : ?>
                <?php foreach ($optonFieldErrors as $optonFieldError) : ?>
                    <li><?php echo esc_html($optonFieldError); ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif;
