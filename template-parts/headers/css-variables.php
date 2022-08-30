<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


$fonts = selleradise_get_fonts();

$header_heights = [
    'default' => '5rem',
    'simple'  => '5rem',
    'common'  => '5rem',
    'minimal' => '5rem',
    'robust' => '8rem',
    'robust-alt' => '8rem',
    'robust-centered' => '8rem',
    'centered' => '5rem',
    'custom' => get_theme_mod('header_custom_height', '5rem'),
];

$header_height = $header_heights[get_theme_mod('header_type', 'default')] ?? '6rem';

$color_variables = [
    'main', 'main_text', 'background', 'text', 'accent_light', 'accent_light_text'
];

?>

<style>
   
    :root {
        <?php 
            foreach($color_variables as $name) {
                $css_property = sprintf('color-%s', str_replace('_', '-', $name));
                $color_value = get_theme_mod('color_'.$name, selleradise_get_default_color($name));
                $color_value_rgb = get_theme_mod('color_'.$name.'_rgb', selleradise_get_default_color($name.'_rgb'));

                echo esc_html(sprintf('--selleradise-%s:%s;', $css_property, $color_value));
                echo esc_html(sprintf('--selleradise-%s-rgb:%s;', $css_property, $color_value_rgb));
            };
       
     
        ?>

        --selleradise-color-light: var(--selleradise-color-background);
        --selleradise-color-dark: var(--selleradise-color-text);
        --selleradise-color-shadow: rgba(0,0,0,0.1);

        <?php 
            foreach($fonts as $key => $font) {
                if(!isset($font['font-weight'])) {
                    $font['font-weight'] = selleradise_get_font_weight($font['variant']);
                }
                
                foreach ($font as $property => $value) {
                    echo esc_html(sprintf('--selleradise-font-%s-%s: %s;', $key, $property, $value));
                }
            };
        ?>

        --border-radius-base: 1.5em;
        --border-radius-half: calc(var(--border-radius-base) / 2);
        --border-radius-fourth: calc(var(--border-radius-base) / 4);
        --border-radius-x2: calc(var(--border-radius-base) * 2);
        --page-padding: 5vw;
        --header-height: <?php echo esc_html( $header_height ); ?>;
        --hero-height: calc(100vh - var(--header-height));
        --product-image-ratio: <?php echo esc_html(selleradise_get_product_image_ratio()); ?>;

        --swiper-preloader-color: var(--selleradise-color-main);
        --swiper-theme-color: var(--selleradise-color-main);
    }

</style>

