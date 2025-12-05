<?php
/**
 * Template for displaying settings validation errors
 *
 * @var array $args['errors'] Array of validation errors
 */
defined('ABSPATH') || exit;

$optonErrors = $args['errors'] ?? [];

if (!empty($optonErrors)) : ?>
    <div class="notice notice-error is-dismissible">
        <p>
            <strong><?php echo esc_html('There were validation errors:') ?></strong>
        </p>

        <ul class="list-disc ml-5">
            <?php foreach ($optonErrors as $optonFieldErrors) : ?>
                <?php foreach ($optonFieldErrors as $optonFieldError) : ?>
                    <li><?php echo esc_html($optonFieldError); ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif;
