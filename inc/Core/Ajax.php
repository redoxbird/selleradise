<?php

namespace THEME_NAMESPACE\Core;

use WC_Product_Query;
use WP_Query;

/**
 * Ajax.
 */
class Ajax
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public $ajax_events_nopriv = [
        'search_terms',
        'search_posts',
        'get_cart_contents',
        'get_cart_total',
        'remove_item_from_cart',
        'set_cart_item_quantity',
        'get_shop_filter_attributes',
        'get_product_tags',
    ];

    public function register()
    {

        foreach ($this->ajax_events_nopriv as $ajax_event) {
            add_action('wp_ajax_selleradise_' . $ajax_event, [$this, $ajax_event]);
            add_action('wp_ajax_nopriv_selleradise_' . $ajax_event, [$this, $ajax_event]);
        }
    }

    public function search_terms()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $data = [
            "terms" => [],
            "products" => [],
        ];

        if (!class_exists('WooCommerce')) {
            return wp_send_json($data);

            wp_die();
        }

        $keyword = sanitize_text_field($_GET['keyword']);

        $term_args = [
            'orderby' => 'count',
            'order' => 'DESC',
            'hide_empty' => false,
            'number' => 5,
            'taxonomy' => ['product_cat', 'product_tag'],
        ];

        $product_args = [
            'orderby' => 'relevance',
            'order' => 'ASC',
            'return' => 'object',
            'limit' => 5,
            'visibility' => 'search',
        ];

        if ($keyword) {
            $term_args['name__like'] = $keyword;
            $product_args['s'] = $keyword;
        }

        $product_query = new WC_Product_Query($product_args);
        $products = $product_query->get_products();
        $terms = get_terms($term_args);

        $data["products"] = $this->prepare_product_data_for_search_results($products);
        $data["terms"] = $this->prepare_term_data_for_search_results($terms);

        wp_send_json($data);

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    private function prepare_term_data_for_search_results($terms)
    {
        $data = [];

        if (!$terms || empty($terms)) {
            return $data;
        }

        $term_names = array_column($terms, "name");
        $duplicate_names = array_unique(array_diff_assoc($term_names, array_unique($term_names)));

        foreach ($terms as $term) {
            $term_data = [
                "slug" => esc_attr($term->slug),
                "name" => esc_html($term->name),
                "link" => esc_url(get_term_link($term)),
            ];

            if ($term->taxonomy === 'product_cat') {
                $term_product_args['category'][] = $term->slug;
            }

            if ($term->taxonomy === 'product_tag') {
                $term_product_args['tag'][] = $term->slug;
            }

            if (in_array($term->name, $duplicate_names)) {
                $term_data["is_duplicate_name"] = true;
            }

            if ($term->parent) {
                $parent = get_term($term->parent, $term->taxonomy);
                $term_data["parent_term"] = $parent;
            }

            $data[] = $term_data;
        }

        return $data;
    }

    private function prepare_product_data_for_search_results($products)
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $data = [];

        foreach ($products as $product) {
            $product_data = [
                "post_title" => esc_html($product->get_name()),
                "guid" => esc_url(get_permalink($product->get_id())),
                "price" => wp_kses_post($product->get_price_html()),
                "id" => $product->get_id(),
                'image' => $product->get_image('thumbnail'),
            ];

            $image = $product->get_image_id();

            if (!$image) {
                $product_data["image_url"] = esc_url(wc_placeholder_img_src());
            } else {
                $image_src = wp_get_attachment_image_src($image, 'thumbnail');
                $product_data["image_url"] = esc_url($image_src[0]);
            }

            $data[] = $product_data;
        }

        return $data;
    }

    public function search_posts()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $keyword = sanitize_text_field($_GET['keyword']);

        $args = [
            'post_type' => ['post', 'page'],
            'posts_per_page' => 5,
        ];

        if ($keyword) {
            $args['s'] = $keyword;
        }

        $posts = new WP_Query($args);

        $data = [];

        while ($posts->have_posts()) {
            $posts->the_post();

            $data[] = [
                "title" => esc_html(get_the_title()),
                "link" => esc_url(get_the_permalink()),
            ];

            wp_reset_postdata();
        }

        wp_send_json($data);

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    private function get_cart()
    {
        $cart = [
            "items" => selleradise_get_cart_items_with_product(),
            "count" => function_exists("wc") ? wc()->cart->get_cart_contents_count() : 0,
            "total" => function_exists("wc") ? wc()->cart->get_cart_total() : 0,
        ];

        return $cart;
    }

    public function get_cart_contents()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        wp_send_json($this->get_cart());

        wp_die();
    }

    public function get_cart_total()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        wp_send_json_success(wc()->cart->get_cart_total());

        wp_die();
    }

    public function remove_item_from_cart()
    {

        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $key = sanitize_text_field($_GET['key']);

        $remove_item = wc()->cart->remove_cart_item($key);

        if (!$remove_item) {
            wp_send_json_error([
                'message' => 'Error occurred while removing product from cart',
            ]);

            wp_die();
        }

        wp_send_json_success($this->get_cart());

        wp_die();
    }

    public function set_cart_item_quantity()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        $key = sanitize_text_field($_GET['key']);
        $quantity = sanitize_text_field($_GET['quantity']);

        $set_quantity = wc()->cart->set_quantity($key, $quantity);

        if (!$set_quantity) {
            wp_send_json_error([
                'message' => __('Error occurred while updating product in cart', '[TEXT_DOMAIN]'),
            ]);

            wp_die();
        }

        wp_send_json_success($this->get_cart());

        wp_die();
    }


    public function get_shop_filter_attributes()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        if (!class_exists('WooCommerce')) {
            return wp_send_json([]);

            wp_die();
        }

        $attributes = wc_get_attribute_taxonomies();
        $attributes_with_values = [];

        foreach ($attributes as $key => $attribute) {
            $attribute_values = get_terms(wc_attribute_taxonomy_name($attribute->attribute_name), array(
                'hide_empty' => false,
                'orderby' => 'name',
                'order' => 'ASC',
                'number' => 100,
            ));

            foreach ($attribute_values as $key => $attribute_value) {
                $color = get_term_meta($attribute_value->term_id, 'product_attribute_color');

                if ($color) {
                    $attribute_values[$key]->color = $color[0];
                }
            }

            $attribute->attribute_values = $attribute_values;

            if (!empty($attribute_values)) {
                $attributes_with_values[] = $attribute;
            }
        }

        wp_send_json($attributes_with_values);

        wp_die();
    }

    public function get_product_tags()
    {
        if (!isset($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'selleradise_ajax')) {

            wp_send_json([
                'message' => 'Invalid Request',
            ]);

            wp_die();
        };

        if (!class_exists('WooCommerce')) {
            return wp_send_json([]);

            wp_die();
        }

        $tags = selleradise_get_product_tags();
        
        wp_send_json($tags);

        wp_die();
    }
}
