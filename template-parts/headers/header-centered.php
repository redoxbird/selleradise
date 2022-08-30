<?php // [REMOVE_FILE_IN_LITE]

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

?>

<header
  x-data
  role="banner"
  class="selleradiseHeader fixed z-1000 not-top:bg-background-50 not-top:shadow-b-sm left-0 right-0 w-full flex justify-between items-center px-header h-header"
  x-bind:class="{'headroom--unpinned': !$store.scroll.pin, 'headroom--pinned': $store.scroll.pin, 'headroom--not-top': !$store.scroll.start}"> 
  <div class="lg:flex-1">
    <?php get_template_part('template-parts/headers/partials/menu'); ?>
  </div>
  
  <div class="lg:flex-1">
    <?php get_template_part('template-parts/headers/partials/logo'); ?>
  </div>
  
  <?php get_template_part('template-parts/headers/partials/search');?>

  <div class="lg:flex-1 flex justify-end items-center">
    <?php get_template_part('template-parts/headers/partials/trigger', "search"); ?>
    <?php get_template_part('template-parts/headers/partials/trigger', 'cart'); ?>
    <?php get_template_part('template-parts/headers/partials/trigger', "account"); ?>
    <span class="lg:hidden"><?php get_template_part('template-parts/headers/partials/trigger', 'menu'); ?></span>
  </div>
</header>
