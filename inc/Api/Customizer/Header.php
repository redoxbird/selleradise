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
        
        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'radio',
            'settings' => 'header_type',
            'label' => __('Header Type', '[TEXT_DOMAIN]'),
            'description' => esc_html__('Select a type of header.', '[TEXT_DOMAIN]'),
            'section' => 'selleradise_header',
            'default' => 'default',
            'choices' => [
                'default' => esc_html__('Default', '[TEXT_DOMAIN]'),
                'common' => esc_html__('Common', '[TEXT_DOMAIN]'),
                'minimal' => esc_html__('Minimal', '[TEXT_DOMAIN]'),
                'simple' => esc_html__('Simple', '[TEXT_DOMAIN]'),
                'centered' => esc_html__('Centered', '[TEXT_DOMAIN]'),
                'robust' => esc_html__('Robust', '[TEXT_DOMAIN]'),
                'robust-alt' => esc_html__('Robust Alt', '[TEXT_DOMAIN]'),
                'robust-centered' => esc_html__('Robust Centered', '[TEXT_DOMAIN]'),
                'custom' => esc_html__('Custom', '[TEXT_DOMAIN]'),
            ],
            'transport' => 'refresh',
        ]);

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'code',
            'settings' => 'header_custom_code',
            'label' => esc_html__('Custom header html', '[TEXT_DOMAIN]'),
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

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'dimension',
            'settings' => 'header_custom_height',
            'label' => esc_html__('Custom header height', '[TEXT_DOMAIN]'),
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
