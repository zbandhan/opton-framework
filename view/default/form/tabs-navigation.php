<?php
/**
 * Template for form tabs navigation
 *
 * @var array $args['menus'] Array of menu items [id => label]
 */
defined('ABSPATH') || exit;

$optonMenus = $args['menus'] ?? [];

if (!empty($optonMenus)) : ?>
    <div class="opton-tabs">
        <ul class="opton-tab-nav flex list-none border-b border-solid border-[#ccc]">
            <?php
            $optonFirst = true;
            foreach ($optonMenus as $optonPageId => $optonMenuTitle) :
                $optonActiveClass = $optonFirst ? ' opton-tab-active' : '';
                $optonBackground = $optonFirst ? '#fff' : '#f5f5f5';
            ?>
                <li class="m-0!">
                    <a href="#opton-page-<?php echo esc_attr($optonPageId); ?>"
                       class="opton-tab-link<?php echo esc_attr($optonActiveClass); ?> block no-underline border border-[#ccc] border-b-0 bg-[<?php echo esc_attr($optonBackground); ?>] mr-[5px] py-2.5 px-5"
                       data-page="<?php echo esc_attr($optonPageId); ?>"
                    >
                        <?php echo esc_html($optonMenuTitle); ?>
                    </a>
                </li>
            <?php
                $optonFirst = false;
            endforeach;
            ?>
        </ul>
    </div>
<?php endif;
