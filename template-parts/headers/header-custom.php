<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

?>

<header
  x-data
  role="banner"
  class="selleradiseHeader fixed z-1000 not-top:bg-background-900 not-top:shadow-b-sm left-0 right-0 w-full flex justify-between items-center px-header h-header"
  x-bind:class="{'headroom--unpinned': !$store.scroll.pin, 'headroom--pinned': $store.scroll.pin, 'headroom--not-top': !$store.scroll.start}">
  
  <?php echo do_shortcode(wp_kses_post(get_theme_mod('header_custom_code', ''))); ?>
  
</header>
