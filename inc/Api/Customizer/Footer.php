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
class Footer
{
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

        Kirki::add_section('selleradise_footer', array(
            'title' => esc_html__('Footer', '[TEXT_DOMAIN]'),
            'description' => esc_html__('Settings for footer section.', '[TEXT_DOMAIN]'),
            'priority' => 30,
        ));

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'radio',
            'settings' => 'footer_type',
            'label' => __('Footer Type', '[TEXT_DOMAIN]'),
            'description' => esc_html__('Select the type of footer.', '[TEXT_DOMAIN]'),
            'section' => 'selleradise_footer',
            'default' => 'default',
            'choices' => [
                'default' => esc_html__('Default', '[TEXT_DOMAIN]'),
                'minimal' => esc_html__('Minimal', '[TEXT_DOMAIN]'),
            ],
            'transport' => 'refresh',
        ]);

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'text',
            'settings' => 'copyright_notice',
            'label' => esc_html__('Copyright notice', '[TEXT_DOMAIN]'),
            'section' => 'selleradise_footer',
            'default' => sprintf(esc_html__( 'Copyright © %1$s | All rights reserved by %2$s', '[TEXT_DOMAIN]' ), date("Y"), get_bloginfo("name")),
        ]);

        Kirki::add_field('[TEXT_DOMAIN]', [
            'type' => 'checkbox',
            'settings' => 'disable_back_to_top',
            'label' => esc_html__('Disable back to top button?', '[TEXT_DOMAIN]'),
            'section' => 'selleradise_footer',
            'default' => false,
        ]);

    }
}
