<?php

/**
 * Theme Customizer - Presets
 *
 * @package Selleradise
 */

namespace THEME_NAMESPACE\Api\Customizer;

use Kirki;
use THEME_NAMESPACE\Api\Customizer;

/**
 * Customizer class
 */
class Shop
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {

        if (!class_exists('Kirki') || !class_exists('WooCommerce')) {
            return;
        }

        if (!is_customize_preview()) {
            return;
        }

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'radio',
            'settings' => 'filters_location',
            'label' => __('Shop Filter Location', '[TEXT_DOMAIN]'),
            'description' => esc_html__('Where to show the filters for the product catalog?', '[TEXT_DOMAIN]'),
            'section' => 'woocommerce_product_catalog',
            'default' => 'sidebar',
            'priority' => 30,
            'choices' => [
                'sidebar' => esc_html__('Right Sidebar', '[TEXT_DOMAIN]'),
                'offscreen' => esc_html__('Off Screen', '[TEXT_DOMAIN]'),
                'sidebar-left' => esc_html__('Left Sidebar', '[TEXT_DOMAIN]'),
            ],
            'transport' => 'refresh',
        ]);

        // <REMOVE_IN_LITE>

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'radio',
            'settings' => 'shop_page_card_type',
            'label' => __('Product Card Type', '[TEXT_DOMAIN]'),
            'description' => esc_html__('Which type of card design should be used for the shop?', '[TEXT_DOMAIN]'),
            'section' => 'woocommerce_product_catalog',
            'default' => 'default',
            'priority' => 40,
            'choices' => [
                'default' => esc_html__('Default', '[TEXT_DOMAIN]'),
                'minimal' => esc_html__('Minimal', '[TEXT_DOMAIN]'),
                'simple' => esc_html__('Simple', '[TEXT_DOMAIN]'),
                'list' => esc_html__('List', '[TEXT_DOMAIN]'),
                'compact' => esc_html__('Compact', '[TEXT_DOMAIN]'),
                'rounded' => esc_html__('Rounded', '[TEXT_DOMAIN]'),
            ],
            'transport' => 'refresh',
        ]);
        
        // </REMOVE_IN_LITE>

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'multicheck',
            'settings' => 'shop_filters_to_show',
            'label' => __('Filters To Show', '[TEXT_DOMAIN]'),
            'description' => esc_html__('Which filters should be visible in the sidebar?', '[TEXT_DOMAIN]'),
            'section' => 'woocommerce_product_catalog',
            'default'  => [ 'price', 'categories', 'attributes', 'tags' ],
            'priority' => 50,
            'choices' => [
                'price' => esc_html__('Price', '[TEXT_DOMAIN]'),
                'categories' => esc_html__('Categories', '[TEXT_DOMAIN]'),
                'attributes' => esc_html__('Attributes', '[TEXT_DOMAIN]'),
                'tags' => esc_html__('Tags', '[TEXT_DOMAIN]'),
            ],
            'transport' => 'refresh',
        ]);

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'checkbox',
            'settings' => 'shop_filters_submit_on_change',
            'label' => __('Submit Filters Form On Change', '[TEXT_DOMAIN]'),
            'section' => 'woocommerce_product_catalog',
            'default' => false,
            'priority' => 60,
            'transport' => 'refresh',
        ]);

    }
}
