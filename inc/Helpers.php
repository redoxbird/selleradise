<?php

/**
 * Helpers methods
 *
 * @package Selleradise
 */

if (!function_exists('selleradise_dd')) {
    /**
     * Var_dump and die method
     *
     * @return void
     */
    function selleradise_dd()
    {
        echo '<pre>';
        array_map(function ($x) {
            var_dump($x);
        }, func_get_args());
        echo '</pre>';
        die;
    }
}

if (!function_exists('selleradise_truncate')) {
    /**
     * Truncates a string with a given length.
     *
     * @param  string  $string
     * @param  int  $length
     * @param  string  $append
     * @return string
     */

    function selleradise_truncate($string, $length = 100, $append = "&hellip;")
    {
        $string = trim($string);

        if (strlen($string) > $length) {
            $string = wordwrap($string, $length);
            $string = explode("\n", $string, 2);
            $string = $string[0] . $append;
        }

        return $string;
    }
}

if (!function_exists('selleradise_starts_with')) {
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     */
    function selleradise_starts_with($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && substr($haystack, 0, strlen($needle)) === (string) $needle) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('selleradise_assets')) {
    /**
     * Get assets folder url.
     *
     * @param  string  $path
     * @return string
     */

    function selleradise_assets($path)
    {
        if (!$path) {
            return;
        }

        return get_template_directory_uri() . '/assets/dist/' . $path;
    }
}

if (!function_exists('selleradise_svg')) {
    /**
     * Get inline svg from a file.
     *
     * @param  string  $filename
     * @return string
     */

    function selleradise_svg($filename)
    {

        if (!$filename) {
            return;
        }

        $file_location = get_template_directory() . '/assets/dist/svg/' . $filename . '.svg';

        if (!file_exists($file_location)) {
            return;
        }

        return file_get_contents($file_location);
    }
}

if (!function_exists('selleradise_hex_to_rgb')) {
    /**
     * Get RGB color from a hex color.
     *
     * @param string $hex
     * @param bool $alpha
     * @return string rgb value
     */

    function selleradise_hex_to_rgb($hex, $alpha = false)
    {
        if (!$hex) {
            return;
        }

        $hex = str_replace('#', '', sanitize_hex_color($hex));
        $length = strlen($hex);

        $r = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $g = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $b = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));

        if ($alpha) {
            $a = $alpha;
            return sprintf('%s,%s,%s,%s', $r, $g, $b, $a);
        }

        return sprintf('%s,%s,%s', $r, $g, $b);
    }
}

if (!function_exists('selleradise_rgb_to_hsl')) {
    /**
     * Converts rgb color to hsl.
     *
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return array [h,s,l]
     */

    function selleradise_rgb_to_hsl($red, $green, $blue): array
    {
        $r = $red / 255;
        $g = $green / 255;
        $b = $blue / 255;

        $cmax = max($r, $g, $b);
        $cmin = min($r, $g, $b);
        $delta = $cmax - $cmin;

        $hue = 0;
        if ($delta != 0) {
            if ($r === $cmax) {
                $hue = 60 * fmod(($g - $b) / $delta, 6);
            }

            if ($g === $cmax) {
                $hue = 60 * ((($b - $r) / $delta) + 2);
            }

            if ($b === $cmax) {
                $hue = 60 * ((($r - $g) / $delta) + 4);
            }
        }

        $lightness = ($cmax + $cmin) / 2;

        $saturation = 0;

        if ($lightness > 0 && $lightness < 1) {
            $saturation = $delta / (1 - abs((2 * $lightness) - 1));
        }

        return [round($hue), round(min($saturation, 1) * 100), round(min($lightness, 1) * 100)];
    }
}

if (!function_exists('selleradise_get_theme_type')) {
    /**
     * Get either light or dark theme.
     *
     * @return string
     */

    function selleradise_get_theme_type()
    {
        $theme_type = get_theme_mod('theme_type', 'light');

        if ($theme_type == "both") {

            if (!empty($_COOKIE['darkMode']) && $_COOKIE['darkMode'] === "true") {
                return "dark";
            } else {
                return "light";
            }
        }

        return $theme_type;
    }
}

if (!function_exists('selleradise_get_menu_items_by_registered_slug')) {
    /**
     * Get menu items array by a registered slug.
     *
     * @param string $slug
     * @return array $menu_items
     */

    function selleradise_get_menu_items_by_registered_slug($menu_slug)
    {

        $menu_items = [];

        if (($locations = get_nav_menu_locations()) && isset($locations[$menu_slug])) {
            $menu = get_term($locations[$menu_slug]);

            if (!isset($menu->term_id)) {
                return $menu_items;
            }

            $menu_items = wp_get_nav_menu_items($menu->term_id);
        }

        return $menu_items;
    }
}

if (!function_exists('selleradise_get_menu_tree')) {
    /**
     * Get menu items array by a registered slug.
     *
     * @param string $slug
     * @return array $menu_items
     */

    function selleradise_get_menu_tree($menu_slug)
    {

        $menu = [];

        if (!class_exists('Log1x\Navi\Navi')) {
            return $menu;
        }

        $navigation = new \Log1x\Navi\Navi();

        $navigation->build($menu_slug);

        if ($navigation->isEmpty() === false) {
            $menu = $navigation->toArray();
        }

        return $menu;
    }
}

if (!function_exists('selleradise_get_options')) {
    /**
     * Return variation info.
     *
     * @return array
     */

    function selleradise_get_options($product, $json = false)
    {

        if ($product->get_type() != 'variable') {
            return;
        }

        $attributes = $product->get_variation_attributes();

        if (empty($attributes)) {
            return;
        }

        $attributes_formatted = [];

        foreach ($attributes as $attribute => $options):

            $attributes_formatted[$attribute] = [
                'name' => wc_attribute_label($attribute),
            ];

            if (empty($options)) {
                return;
            }

            if ($product && taxonomy_exists($attribute)) {

                // Get terms if this is a taxonomy - ordered. We need the names too.
                $terms = wc_get_product_terms(
                    $product->get_id(),
                    $attribute,
                    array(
                        'fields' => 'all',
                    )
                );

                foreach ($terms as $term) {
                    if (in_array($term->slug, $options, true)) {
                        $attributes_formatted[$attribute]['options'][] = [
                            'slug' => $term->slug,
                            'name' => apply_filters('woocommerce_variation_option_name', $term->name, $term, $attribute, $product),
                        ];
                    }
                }
            } else {
                foreach ($options as $option) {
                    $attributes_formatted[$attribute]['options'][] = [
                        'slug' => $option,
                        'name' => apply_filters('woocommerce_variation_option_name', $option, null, $attribute, $product),
                    ];
                }
            }

        endforeach;

        if ($json) {
            $attributes_json = wp_json_encode($product->get_available_variations());
            return function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);
        }

        return $attributes_formatted;
    }
}

if (!function_exists('selleradise_get_product_categories')) {

    /**
     * Gets product categories.
     *
     * @param int $limit
     * @return array $product_categories
     */

    function selleradise_get_product_categories($limit = 1000)
    {
        if (!class_exists('WooCommerce')) {
            return [];
        }

        $terms = get_terms('product_cat', array(
            'hide_empty' => true,
            'orderby' => 'count',
            'order' => 'ASC',
            'number' => $limit,
        ));

        if (!$terms) {
            return [];
        }

        return $terms;
    }
}

if (!function_exists('selleradise_get_product_categories_tree')) {

    /**
     * Gets product categories.
     *
     * @return array $product_categories
     */

    function selleradise_get_product_categories_tree()
    {

        $categories_tree = get_transient('selleradise_categories_tree');

        if ($categories_tree) {
            return $categories_tree;
        }

        $categories = selleradise_get_product_categories();

        if (false === $categories_tree) {
            $categories = selleradise_get_product_categories();
            $data = [];

            if (!$categories || empty($categories)) {
                return $data;
            }

            foreach ($categories as $term) {
                $image = [];
                $image["id"] = (int) esc_attr(get_term_meta($term->term_id, 'thumbnail_id', true));
                $image["thumbnail"] = wp_get_attachment_image_src($image["id"], 'thumbnail');
                $image["alt"] = esc_attr(get_post_meta($image["id"], '_wp_attachment_image_alt', true));

                $data[] = [
                    'term_id' => (int) esc_attr($term->term_id),
                    'slug' => esc_attr($term->slug),
                    'name' => esc_html($term->name),
                    'url' => esc_url(get_term_link($term)),
                    'description' => esc_html($term->description),
                    'parent' => (int) esc_attr($term->parent),
                    'count' => (int) esc_attr($term->count),
                    'image' => $image,
                ];
            }

            $categories_tree = selleradise_create_tree($data, 'parent', 'term_id');

            set_transient('selleradise_categories_tree', $categories_tree, DAY_IN_SECONDS);

            return $categories_tree;
        }
    }
}

if (!function_exists('selleradise_get_product_tags')) {
    /**
     * Gets product tags.
     *
     * @param int $limit
     * @return array $product_tags
     */

    function selleradise_get_product_tags($limit = 10000)
    {
        if (!class_exists('WooCommerce')) {
            return;
        }

        $terms = get_terms('product_tag', array(
            'hide_empty' => false,
            'orderby' => 'count',
            'order' => 'DESC',
            'number' => $limit,
        ));

        if (!$terms) {
            return;
        }

        $product_tags = [];

        foreach ($terms as $term) {

            $product_tags[] = (object) [
                'term_id' => esc_attr($term->term_id),
                'slug' => esc_attr($term->slug),
                'name' => esc_html($term->name),
                'url' => esc_url(get_term_link($term)),
            ];
        }

        return $product_tags;
    }
}

if (!function_exists('selleradise_get_cart_items_with_product')) {
    /**
     * Get cart items with product info.
     *
     * @param array $items
     * @return array $items
     */

    function selleradise_get_cart_items_with_product()
    {
        if (!class_exists('WooCommerce')) {
            return [];
        }

        $items = wc()->cart->get_cart_contents();

        foreach ($items as $key => $item) {

            $product = wc_get_product($item['product_id']);
            $_product = apply_filters('woocommerce_cart_item_product', $item['data'], $item, $key);

            $data = null;

            $data["name"] = wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $item, $key));
            $data["link"] = wp_kses_post(apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($item) : '', $item, $key));
            $data["image"] = wp_kses_post(apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $item, $key));
            $data['price'] = wp_kses_post(apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $item, $key));
            $data['stock_quantity'] = $product->get_max_purchase_quantity();
            $items[$key]['product'] = $data;
        }

        return $items;
    }
}

if (!function_exists('selleradise_get_icon')) {
    /**
     * Get icon name from a key.
     *
     * @param string $key
     * @return string
     */

    function selleradise_get_icon($key)
    {

        $icon_types = [
            'simple' => 'tabler-icons/plus',
            'external' => 'tabler-icons/external-link',
            'variable' => 'tabler-icons/eye',
            'grouped' => 'tabler-icons/eye',
            'dashboard' => 'tabler-icons/dashboard',
            'orders' => 'tabler-icons/truck-delivery',
            'downloads' => 'tabler-icons/cloud-download',
            'subscriptions' => 'tabler-icons/hand-click',
            'edit-address' => 'tabler-icons/home',
            'edit-account' => 'tabler-icons/user-circle',
            'customer-logout' => 'tabler-icons/logout',
            'out-of-stock' => 'tabler-icons/alert-triangle',
            'star' => 'fontawesome/star-solid',
            'star-outline' => 'tabler-icons/star',
            'menu_order' => 'tabler-icons/sort-ascending-numbers',
            'popularity' => 'tabler-icons/award',
            'rating' => 'tabler-icons/star',
            'date' => 'tabler-icons/calendar',
            'price' => 'tabler-icons/sort-ascending-numbers',
            'price-desc' => 'tabler-icons/sort-descending-numbers',
            'relevance' => 'tabler-icons/bulb',
        ];

        return $icon_types[$key] ?? false;
    }
}

if (!function_exists('selleradise_get_font_weight')) {

    function selleradise_get_font_weight($variant)
    {

        $variants = [
            'regular' => '400',
            '500' => '500',
            '100' => '100',
            '100light' => '100',
            '100italic' => '100',
            '200' => '200',
            '200italic' => '200',
            '300' => '300',
            '300italic' => '300',
            '400' => '400',
            'italic' => '400',
            '500italic' => '500',
            '600' => '600',
            '600bold' => '600',
            '600italic' => '600',
            '700' => '700',
            '700italic' => '700',
            '800' => '800',
            '800bold' => '800',
            '800italic' => '800',
            '900' => '900',
            '900bold' => '900',
            '900italic' => '900',
        ];

        return $variants[$variant] ?? 400;
    }
}

if (!function_exists('selleradise_get_default_fonts')) {

    function selleradise_get_default_fonts($key = false)
    {
        $fonts = [
            'primary' => [
                'font-family' => 'Inter',
                'variant' => 'regular',
            ],
            'primary_bolder' => [
                'font-family' => 'Inter',
                'variant' => '500',
            ],
            'primary_boldest' => [
                'font-family' => 'Inter',
                'variant' => '600',
            ],
            'heading' => [
                'font-family' => 'Poppins',
                'variant' => '600',
            ],
        ];

        if ($key) {
            return $fonts[$key];
        }

        return $fonts;
    }
}

if (!function_exists('selleradise_get_fonts')) {

    function selleradise_get_fonts($_key = false)
    {
        $default_fonts = selleradise_get_default_fonts();
        $fonts = [];

        foreach ($default_fonts as $key => $value) {
            $fonts[$key] = get_theme_mod('font_' . $key, $value);

            if (!$fonts[$key]) {
                $fonts[$key] = $value;
            }
        }

        if ($_key !== false && isset($fonts[$_key])) {
            return $fonts[$_key];
        }

        return $fonts;
    }
}

if (!function_exists('selleradise_get_image_placeholder')) {

    function selleradise_get_image_placeholder()
    {
        return selleradise_assets('images/placeholder.png');
    }
}

if (!function_exists('selleradise_get_breadcrumb')) {

    function selleradise_get_breadcrumb()
    {
        $args = array(
            'container' => 'nav',
            'before' => '',
            'after' => '',
            'browse_tag' => 'h2',
            'list_tag' => 'ul',
            'item_tag' => 'li',
            'divider' => selleradise_svg('tabler-icons/chevron-right'),
            'show_on_front' => true,
            'network' => false,
            'show_title' => true,
            'show_browse' => false,
            'labels' => array(
                'browse' => esc_html__('Browse:', '[TEXT_DOMAIN]'),
                'aria_label' => esc_attr_x('Breadcrumbs', 'breadcrumbs aria label', '[TEXT_DOMAIN]'),
                'aria_label_home' => esc_attr_x('Home', 'breadcrumbs aria label', '[TEXT_DOMAIN]'),
                'home' => selleradise_svg('tabler-icons/home'),
                'error_404' => esc_html__('404 Not Found', '[TEXT_DOMAIN]'),
                'archives' => esc_html__('Archives', '[TEXT_DOMAIN]'),
                // Translators: %s is the search query.
                'search' => esc_html__('Search results for: %s', '[TEXT_DOMAIN]'),
                // Translators: %s is the page number.
                'paged' => esc_html__('Page %s', '[TEXT_DOMAIN]'),
                // Translators: %s is the page number.
                'paged_comments' => esc_html__('Comment Page %s', '[TEXT_DOMAIN]'),
                // Translators: Minute archive title. %s is the minute time format.
                'archive_minute' => esc_html__('Minute %s', '[TEXT_DOMAIN]'),
                // Translators: Weekly archive title. %s is the week date format.
                'archive_week' => esc_html__('Week %s', '[TEXT_DOMAIN]'),

                // "%s" is replaced with the translated date/time format.
                'archive_minute_hour' => '%s',
                'archive_hour' => '%s',
                'archive_day' => '%s',
                'archive_month' => '%s',
                'archive_year' => '%s',
            ),
            'post_taxonomy' => array(
                // 'post'  => 'post_tag', // 'post' post type and 'post_tag' taxonomy
                // 'book'  => 'genre',    // 'book' post type and 'genre' taxonomy
            ),
            'echo' => true,
        );

        $breadcrumb = new THEME_NAMESPACE\Plugins\BreadcrumbsTrail;
        $breadcrumb->register($args);

        return $breadcrumb->trail();
    }
}

if (!function_exists('selleradise_get_product_image_ratio')) {

    function selleradise_get_product_image_ratio()
    {
        if (!class_exists('WooCommerce')) {
            return 1;
        }

        if (get_option('woocommerce_thumbnail_cropping') === 'custom') {
            if (!get_option('woocommerce_thumbnail_cropping_custom_height') || !get_option('woocommerce_thumbnail_cropping_custom_width')) {
                return 1;
            };

            return (int) get_option('woocommerce_thumbnail_cropping_custom_height') / (int) get_option('woocommerce_thumbnail_cropping_custom_width');
        }

        return 1;
    }
}

if (!function_exists('selleradise_blog_page_classes')) {
    function selleradise_blog_page_classes()
    {
        $classes = ['selleradise-container', 'selleradise-page--blog flex justify-start pb-6 items-stretch flex-wrap'];

        if (is_active_sidebar('selleradise-sidebar')) {
            $classes[] = 'selleradise-page--blog-has-sidebar';
        }

        return implode(' ', $classes);
    };
}

if (!function_exists('selleradise_get_default_color')) {

    function selleradise_get_default_color($variable)
    {

        $colors = [
            "background" => "#ffffff",
            "text" => '#2A2C3A',
            "main" => '#2647CE',
            "main_text" => '#ffffff',
            "accent_light" => '#FFC947',
            "accent_light_text" => '#2A2C3A',

            "background_rgb" => '255,255,255',
            "text_rgb" => "42,44,58",
            "main_rgb" => '38, 71, 206',
            "main_text_rgb" => '255,255,255',
            "accent_light_rgb" => '255, 201, 71',
            "accent_light_text_rgb" => '42,44,58',

            "dark-theme_background" => "#2A2C3A",
            "dark-theme_text" => '#ffffff',
            "dark-theme_main" => '#8296e8',
            "dark-theme_accent_light" => '#FFC947',
            "dark-theme_main_text" => '#2A2C3A',
            "dark-theme_accent_light_text" => '#2A2C3A',

            "dark-theme_background_rgb" => '42,44,58',
            "dark-theme_text_rgb" => "255,255,255",
            "dark-theme_main_rgb" => '130, 150, 232',
            "dark-theme_main_text_rgb" => '42,44,58',
            "dark-theme_accent_light_rgb" => '255, 201, 71',
            "dark-theme_accent_light_text_rgb" => '42,44,58',
        ];

        return $colors[$variable];
    }
}

if (!function_exists('selleradise_kirki_heading')) {

    function selleradise_kirki_heading($text = '')
    {
        if (!$text) {
            return;
        }

        return '<h3 style="margin:30px 0 10px 0; font-size: 25px; color: inherit; line-height: 1.2;">' . wp_kses_post($text) . '</h3>';
    }
}

if (!function_exists('selleradise_kses_ruleset')) {

    function selleradise_kses_ruleset()
    {
        $kses_defaults = wp_kses_allowed_html('post');

        $svg_args = array(
            'svg' => array(
                'class' => true,
                'aria-hidden' => true,
                'aria-labelledby' => true,
                'stroke-width' => true,
                'stroke' => true,
                'stroke-linecap' => true,
                'stroke-linejoin' => true,
                'fill' => true,
                'role' => true,
                'xmlns' => true,
                'width' => true,
                'height' => true,
                'viewbox' => true, // <= Must be lower case!
            ),
            'g' => array('fill' => true),
            'title' => array('title' => true),
            'path' => array(
                'd' => true,
                'fill' => true,
                'stroke' => true,
            ),
            'polyline' => array(
                'points' => true
            )
        );
        return array_merge($kses_defaults, $svg_args);
    }
}

if (!function_exists('selleradise_query_has_filters')) {

    function selleradise_query_has_filters($query_keys)
    {
        if (empty($query_keys)) {
            return false;
        }

        $filters = ['product_cat', 'product_tag', 'min_price', 'max_price'];

        $attributes = wc_get_attribute_taxonomies();

        if ($attributes) {
            $attribute_names = array_column($attributes, 'attribute_name');
            $filters = array_merge($filters, $attribute_names);
        }

        $intersect = array_intersect($filters, $query_keys);

        if ($intersect && !empty($intersect)) {
            return true;
        }

        return false;
    }
}

if (!function_exists('selleradise_create_tree')) {

    function selleradise_create_tree(array $flat, $parent_key, $key)
    {
        $root = 0;

        $parents = array();
        foreach ($flat as $a) {
            $parents[$a[$parent_key]][] = $a;
        }

        return selleradise_create_branch($parents, $parents[$root], $key);
    }
}

if (!function_exists('selleradise_create_branch')) {

    function selleradise_create_branch(&$parents, $children, $key)
    {
        $tree = array();
        foreach ($children as $child) {
            if (isset($parents[$child[$key]])) {
                $child['children'] =
                    selleradise_create_branch($parents, $parents[$child[$key]], $key);
            }
            $tree[] = $child;
        }
        return $tree;
    }
}

if (!function_exists('selleradise_trending_posts_reset_time')) {

    function selleradise_trending_posts_reset_time($format = false)
    {

        $reset_time = DateTime::createFromFormat('j H:i:s', '1 00:00:00');

        if ($format) {
            return $reset_time->format($format);
        }

        return $reset_time;
    }
}

if (!function_exists('selleradise_get_shop_max_price')) {

    function selleradise_get_shop_max_price()
    {
        $max_price = get_transient('selleradise_get_shop_max_price');

        if ($max_price) {
            return $max_price ?? 1000;
        }

        global $wpdb;

        $result = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM $wpdb->postmeta WHERE `meta_key` = %s ORDER BY CAST(`meta_value` as decimal) DESC LIMIT 1",
                ['_price']
            )
        );

        $max_price = $result[0]->meta_value ?? 1000;

        set_transient('selleradise_get_shop_max_price', $max_price, DAY_IN_SECONDS);

        return $max_price;
    }
}

if (!function_exists('selleradise_is_woocommerce_page')) {

    function selleradise_is_woocommerce_page()
    {
        if (!class_exists('WooCommerce')) {
            return false;
        }

        return is_cart() || is_checkout() || is_account_page() || is_shop();
    }
}

if (!function_exists('selleradise_is_normal_mode')) {

    function selleradise_is_normal_mode()
    {
        if (!class_exists('\Elementor\Plugin')) {
            return true;
        }

        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            return false;
        }

        return true;
    }
}

if (!function_exists('selleradise_lazy_src')) {

    function selleradise_lazy_src($src)
    {
        if (selleradise_is_normal_mode()) {
            return sprintf(
                '%s="%s" src="%s"',
                'x-lazy:src',
                $src,
                selleradise_get_image_placeholder()
            );
        } else {
            return sprintf(
                '%s="%s"',
                'src',
                $src
            );
        }
    }
}

if (!function_exists('selleradise_nav_classes')) {

    function selleradise_nav_classes($tag = "ul", $level = 1)
    {
        if ($tag === "ul") {
            if ($level === 1) {
                return "relative m-0 p-0 flex nowrap justify-start items-center";
            } else if ($level === 2) {
                return "m-0 bg-white border-1 border-solid rounded-lg p-2 border-gray-200 absolute left-0 min-w-full top-full";
            } else if ($level > 2) {
                return "m-0 bg-white border-1 border-solid rounded-lg p-2 border-gray-200 absolute left-full ml-2 min-w-44 min-h-full top-0";
            };
        } else if ($tag === "li") {
            if ($level === 1) {
                return "relative whitespace-nowrap list-none flex justify-between flex-wrap items-center";
            } else if ($level > 1) {
                return "relative flex-1 whitespace-nowrap list-none flex justify-between flex-wrap items-center w-full my-2";
            };
        } else if ($tag === "a") {
            if ($level === 1) {
                return "flex justify-center items-center nowrap px-4 py-1 font-semibold text-sm text-text-900 focus-within:bg-gray-100 rounded-full";
            } else if ($level > 1) {
                return "flex w-full justify-start items-center nowrap px-4 py-1 font-semibold text-sm text-text-900 focus-within:bg-gray-100 rounded-full";
            };
        }

        return;
    }
}

if (!function_exists('selleradise_products_classes')) {

    function selleradise_products_classes($card_type, $fullwidth = false)
    {
        $cols = [];

        if ($fullwidth) {
            $cols = [
                "default" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 4,
                ],
                "minimal" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 4,
                ],
                "simple" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 4,
                ],
                "compact" => [
                    "sm" => 2,
                    "md" => 4,
                    "lg" => 7,
                ],
                "list" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 3,
                ],
                "rounded" => [
                    "sm" => 1,
                    "md" => 3,
                    "lg" => 5,
                ],
            ];
        } else {
            $cols = [
                "default" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 3,
                ],
                "minimal" => [
                    "sm" => 1,
                    "md" => 3,
                    "lg" => 3,
                ],
                "simple" => [
                    "sm" => 1,
                    "md" => 3,
                    "lg" => 3,
                ],
                "compact" => [
                    "sm" => 2,
                    "md" => 4,
                    "lg" => 5,
                ],
                "list" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 2,
                ],
                "rounded" => [
                    "sm" => 1,
                    "md" => 3,
                    "lg" => 4,
                ],
            ];
        }

        return "grid-cols-" . $cols[$card_type]['sm'] . " md:grid-cols-" . $cols[$card_type]['md'] . " lg:grid-cols-" . $cols[$card_type]['lg'];
    }
}


if (!function_exists('selleradise_posts_classes')) {

    function selleradise_posts_classes($card_type, $fullwidth = false)
    {
        $cols = [];

        if ($fullwidth) {
            $cols = [
                "default" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 4,
                ],
                "minimal" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 4,
                ],
                "popular" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 4,
                ],
                "text" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 4,
                ],
                "list" => [
                    "sm" => 1,
                    "md" => 1,
                    "lg" => 3,
                ],
            ];
        } else {
            $cols = [
                "default" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 2,
                ],
                "minimal" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 2,
                ],
                "popular" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 2,
                ],
                "text" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 2,
                ],
                "list" => [
                    "sm" => 1,
                    "md" => 2,
                    "lg" => 2,
                ],
            ];
        }

        return "grid-cols-" . $cols[$card_type]['sm'] . " md:grid-cols-" . $cols[$card_type]['md'] . " lg:grid-cols-" . $cols[$card_type]['lg'];
    }
}