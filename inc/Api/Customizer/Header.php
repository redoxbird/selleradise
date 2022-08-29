<?php

/**
 * Theme Customizer - Header
 *
 * @package Selleradise
 */

namespace THEME_NAMESPACE\Api\Customizer;

use Kirki;
use THEME_NAMESPACE\Api\Customizer;

/**
 * Customizer class
 */
class Header
{

    public $palette = [];
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {

        if (!class_exists('Kirki')) {
            return;
        }

        if (!is_customize_preview()) {
            return;
        }

        Kirki::add_section('selleradise_header', array(
            'title' => esc_html__('Header', '[TEXT_DOMAIN]'),
            'description' => esc_html__('Settings for header section.', '[TEXT_DOMAIN]'),
            'priority' => 25,
        ));

        // <REMOVE_IN_LITE>
        
        Kirki::add_field('selleradise', [
            'type' => 'radio',
            'settings' => 'header_type',
            'label' => __('Header Type', 'selleradise'),
            'description' => esc_html__('Select a type of header.', 'selleradise'),
            'section' => 'selleradise_header',
            'default' => 'default',
            'choices' => [
                'default' => esc_html__('Default', 'selleradise'),
                'common' => esc_html__('Common', 'selleradise'),
                'minimal' => esc_html__('Minimal', 'selleradise'),
                'simple' => esc_html__('Simple', 'selleradise'),
                'robust' => esc_html__('Robust', 'selleradise'),
                'robust-alt' => esc_html__('Robust Alt', 'selleradise'),
                'robust-centered' => esc_html__('Robust Centered', 'selleradise'),
                'custom' => esc_html__('Custom', 'selleradise'),
            ],
            'transport' => 'refresh',
        ]);

        Kirki::add_field('selleradise', [
            'type' => 'code',
            'settings' => 'header_custom_code',
            'label' => esc_html__('Custom header html', 'selleradise'),
            'section' => 'selleradise_header',
            'active_callback' => [
                [
                    'setting' => 'header_type',
                    'operator' => '==',
                    'value' => 'custom',
                ],
            ],
            'choices' => [
                'language' => 'html',
            ],
        ]);

        Kirki::add_field('selleradise', [
            'type' => 'dimension',
            'settings' => 'header_custom_height',
            'label' => esc_html__('Custom header height', 'selleradise'),
            'section' => 'selleradise_header',
            'default' => '6rem',
            'active_callback' => [
                [
                    'setting' => 'header_type',
                    'operator' => '==',
                    'value' => 'custom',
                ],
            ],
        ]);

        // </REMOVE_IN_LITE>

    }
}
