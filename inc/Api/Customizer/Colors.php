<?php

/**
 * Theme Customizer - Colors
 *
 * @package Selleradise
 */

namespace THEME_NAMESPACE\Api\Customizer;

use Kirki;
use Kirki_Color;
use THEME_NAMESPACE\Api\Customizer;

/**
 * Customizer class
 */
class Colors
{
    public $palette = [];
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {

        if (!is_customize_preview()) {
            return;
        }

        add_action('wp_head', array($this, 'process'));

        $palettes = $this->palettes();

        $presets = [];

        foreach ($palettes as $name => $values) {
            $settings = [];

            $settings['color_background'] = $palettes[$name]['light']['color_light'];
            $settings['color_main'] = $palettes[$name]['light']['color_main'];
            $settings['color_text'] = $palettes[$name]['light']['color_dark'];
            $settings['color_accent_light'] = $palettes[$name]['light']['color_accent_light'];

            $this->palette[$name] = $palettes[$name]['light'];

            $presets[$name] = [
                'settings' => $settings,
            ];
        }

        Kirki::add_section('selleradise_colors', array(
            'title' => esc_html__('Colors', '[TEXT_DOMAIN]'),
            'description' => esc_html__('Set color for the website.', '[TEXT_DOMAIN]'),
            'priority' => 22,
        ));


        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'custom',
            'settings' => 'title_light_mode_color',
            'section' => 'selleradise_colors',
            'default' => selleradise_kirki_heading('Colors'),
        ]);

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'color',
            'settings' => 'color_main',
            'label' => esc_html__('Main', '[TEXT_DOMAIN]'),
            'description' => esc_html__('The main color of the website.', '[TEXT_DOMAIN]'),
            'section' => 'selleradise_colors',
            'default' => selleradise_get_default_color("main"),
            'transport' => 'refresh',
        ]);

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'color',
            'settings' => 'color_main_text',
            'label' => esc_html__('Main Text', '[TEXT_DOMAIN]'),
            'description' => esc_html__('Contrasting color for main color.', '[TEXT_DOMAIN]'),
            'section' => 'selleradise_colors',
            'default' => selleradise_get_default_color('main_text'),
            'transport' => 'refresh',
        ]);

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'color',
            'settings' => 'color_background',
            'label' => __('Background', '[TEXT_DOMAIN]'),
            'description' => esc_html__('a background color.', '[TEXT_DOMAIN]'),
            'section' => 'selleradise_colors',
            'default' => selleradise_get_default_color("background"),
            'transport' => 'refresh',
        ]);

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'color',
            'settings' => 'color_text',
            'label' => __('Text', '[TEXT_DOMAIN]'),
            'description' => esc_html__('text color, make sure that it contrasts well with the background color.', '[TEXT_DOMAIN]'),
            'section' => 'selleradise_colors',
            'default' => selleradise_get_default_color("text"),
            'transport' => 'refresh',
        ]);

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'color',
            'settings' => 'color_accent_light',
            'label' => __('Accent', '[TEXT_DOMAIN]'),
            'description' => esc_html__('an accent color, rarely used.', '[TEXT_DOMAIN]'),
            'section' => 'selleradise_colors',
            'default' => selleradise_get_default_color("accent_light"),
            'transport' => 'refresh',
        ]);

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'color',
            'settings' => 'color_accent_light_text',
            'label' => __('Accent Text', '[TEXT_DOMAIN]'),
            'description' => esc_html__('Contrasting color for accent color.', '[TEXT_DOMAIN]'),
            'section' => 'selleradise_colors',
            'default' => selleradise_get_default_color('accent_light_text'),
            'transport' => 'refresh',
        ]);

        //=========================
        // Color Palette
        //=======================

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'custom',
            'settings' => 'title_color_palette',
            'section' => 'selleradise_colors',
            'default' => selleradise_kirki_heading('Predefined Color Palettes'),
        ]);

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'palette',
            'settings' => 'color_palette',
            'label' => __('Color Palette', '[TEXT_DOMAIN]'),
            'section' => 'selleradise_colors',
            'default' => 'default',
            'choices' => $this->palette,
            'preset' => $presets,
            'transport' => 'refresh',
        ]);

    }

    public function process()
    {
        if (!is_customize_preview()) {
            return;
        }

        $colors = [
            'main', 'background', 'text', 'accent_light',
        ];

        foreach ($colors as $index => $color) {
            $color_mod = get_theme_mod('color_' . $color);
            $dark_mode_color_mod = get_theme_mod('dark_mode_color_' . $color);

            if ($color_mod) {
                $rgb = Kirki_Color::get_rgb($color_mod);
                set_theme_mod('color_' . $color . '_rgb', selleradise_hex_to_rgb($color_mod));
            }

        }

    }

    public function palettes($type = false)
    {
        $palettes = [
            "default" => [
                'light' => [
                    'color_light' => selleradise_get_default_color('background'),
                    'color_main' => selleradise_get_default_color('main'),
                    'color_dark' => selleradise_get_default_color('text'),
                    'color_accent_light' => selleradise_get_default_color('accent_light'),
                ],
                'dark' => [
                    'color_light' => selleradise_get_default_color('dark-theme_text'),
                    'color_main' => selleradise_get_default_color('dark-theme_main'),
                    'color_dark' => selleradise_get_default_color('dark-theme_background'),
                    'color_accent_light' => selleradise_get_default_color('dark-theme_accent_light'),
                ],
            ],
            "fashion" => [
                'light' => [
                    'color_light' => '#FFFFFF',
                    'color_main' => '#5a5df0',
                    'color_dark' => '#212121',
                    'color_accent_light' => '#c7fceb',
                ],
                'dark' => [
                    'color_light' => '#FFFFFF',
                    'color_main' => '#5a5df0',
                    'color_dark' => '#212121',
                    'color_accent_light' => '#c7fceb',
                ],
            ],
            "furniture" => [
                'light' => [
                    'color_light' => '#FFFFFF',
                    'color_main' => '#147c79',
                    'color_dark' => '#212121',
                    'color_accent_light' => '#f9f871',
                ],
                'dark' => [
                    'color_light' => '#FFFFFF',
                    'color_main' => '#57b1ad',
                    'color_dark' => '#212121',
                    'color_accent_light' => '#f9f871',
                ],
            ],
            "cosmetic" => [
                'light' => [
                    'color_light' => '#FFFFFF',
                    'color_main' => '#87678f',
                    'color_dark' => '#4e4351',
                    'color_accent_light' => '#fefedf',
                ],
                'dark' => [
                    'color_light' => '#FFFFFF',
                    'color_main' => '#87678f',
                    'color_dark' => '#4e4351',
                    'color_accent_light' => '#fefedf',
                ],
            ],
        ];

        if ($type) {
            return $palettes[$type]['light'] ?? false;
        }

        return $palettes;

    }
}
