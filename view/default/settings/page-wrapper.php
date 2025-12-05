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
    <h1><?php echo esc_html($optonPageTitle); ?></h1>

    <?php if (!empty($optonDescription)) : ?>
        <p class="description"><?php echo esc_html($optonDescription); ?></p>
    <?php endif; ?>

    <form method="post" action="options.php" class="opton-settings-form">
        <?php
            settings_fields($optonOptionGroup);
            do_settings_sections($optonMenuSlug);
        ?>

        <input type="hidden" name="option_page" value="<?php echo esc_attr($optonOptionGroup); ?>">
        <input type="hidden" name="action" value="update">

        <div class="opton-form-content bg-[#FFF] p-5 mt-5 border border-[#ccc] rounded-sm">
            <?php
                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                echo $optonFormHtml;
            ?>
        </div>

        <?php submit_button('Save Settings', 'primary', 'submit', true); ?>
    </form>
</div>
