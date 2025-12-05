<?php
/**
 * Template for settings page wrapper
 *
 * @var string $args['page_title'] Page title
 * @var string $args['description'] Page description
 * @var string $args['option_group'] Option group name
 * @var string $args['option_name'] Option name
 * @var string $args['menu_slug'] Menu slug
 * @var array|null $args['menus'] Tab menus
 * @var string $args['form_html'] Form HTML content
 */
defined('ABSPATH') || exit;

$optonPageTitle = $args['page_title'] ?? '';
$optonDescription = $args['description'] ?? '';
$optonOptionGroup = $args['option_group'] ?? '';
$optonOptionName = $args['option_name'] ?? '';
$optonMenuSlug = $args['menu_slug'] ?? '';
$optonMenus = $args['menus'] ?? null;
$optonFormHtml = $args['form_html'] ?? '';
?>

<div class="wrap opton-settings-page max-w-[1200px]">
    <form method="post" action="options.php" class="opton-settings-form">
        <?php
            settings_fields($optonOptionGroup);
            do_settings_sections($optonMenuSlug);
        ?>

        <input type="hidden" name="option_page" value="<?php echo esc_attr($optonOptionGroup); ?>">
        <input type="hidden" name="action" value="update">

        <div class="grid grid-cols-[repeat(12,1fr)]">
            <div class="col-start-2 -col-end-1 bg-gray-50 border border-gray-200 rounded-tr-lg px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-900 leading-7 m-0!"><?php echo esc_html($optonPageTitle); ?></h2>
                <?php if (!empty($optonDescription)) : ?>
                    <p class="text-sm text-gray-600 m-0!"><?php echo esc_html($optonDescription); ?></p>
                <?php endif; ?>
            </div>

            <?php
                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo $optonFormHtml;
            ?>

            <div class="flex justify-end-safe col-start-2 -col-end-1 bg-white rounded-br-lg shadow-sm border border-gray-200 overflow-hidden px-10">
                <?php submit_button('Save Settings', 'primary', 'submit', true); ?>
            </div>
        </div>
    </form>
</div>
