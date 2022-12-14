<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

$custom_logo_id = get_theme_mod('custom_logo');
$logo = wp_get_attachment_image_src($custom_logo_id, 'full');

?>

 <a 
    href="<?php echo esc_url( home_url() ); ?>" 
    aria-label="<?php echo esc_attr(sprintf(__('%s Logo', '[TEXT_DOMAIN]'), get_bloginfo('name'))); ?>" 
    class="flex justify-center items-center w-auto py-2 px-4 mr-4">

  <?php if(has_custom_logo()): ?>
    <img
      class="w-auto h-auto max-w-[6rem] md:!max-w-[11rem] max-h-[3rem]"
      src="<?php echo has_custom_logo() ? $logo[0] : selleradise_assets('images/selleradise-logo.svg'); ?>"
      alt="<?php echo esc_attr(sprintf(__('%s Logo', '[TEXT_DOMAIN]'), get_bloginfo('name'))); ?>"
      width="<?php echo esc_attr($logo[1]); ?>"
      height="<?php echo esc_attr($logo[2]); ?>"
    />
  <?php else: ?>
    <span class="selleradiseHeader__logo--dark">
      <?php get_template_part('template-parts/headers/partials/logo', 'placeholder'); ?>
    </span>
  <?php endif; ?>

</a>