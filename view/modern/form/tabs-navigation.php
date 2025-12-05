<?php
/**
 * Template for form tabs navigation
 *
 * @var array $args['menus'] Array of menu items [id => label]
 */
defined('ABSPATH') || exit;

$optonMenus = $args['menus'] ?? [];

if (!empty($optonMenus)) : ?>
    <nav class="w-64 row-start-1 row-end-4 bg-gray-50 text-white border border-gray-200 rounded-tl-lg rounded-bl-lg shadow-sm z-40">
        <div class="opton-tabs p-4">
            <ul class="opton-tab-nav space-y-2">
                <?php
                $optonFirst = true;
                foreach ($optonMenus as $optonPageId => $optonMenuTitle) :
                    $optonActiveClass = $optonFirst ? ' opton-tab-active' : '';
                    $optonBackground = $optonFirst ? '#fff' : '#f5f5f5';
                ?>
                    <li>
                        <a href="#opton-page-<?php echo esc_attr($optonPageId); ?>"
                        class="opton-tab-link<?php echo esc_attr($optonActiveClass); ?> flex items-center bg-[<?php echo esc_attr($optonBackground); ?>] px-4 py-3 text-gray-800! hover:bg-gray-300 border-b! border-[#cdafaf]! hover:border hover:border-[#ddd] shadow-sm rounded-lg transition-colors duration-150"
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
    </nav>
<?php endif;
