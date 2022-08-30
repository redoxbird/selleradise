<?php // [REMOVE_FILE_IN_LITE]

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

?>

<header
  x-data
  role="banner"
  class="selleradiseHeader fixed z-1000 left-0 right-0 w-full h-header duration-700 ease-out-expo transition-all not-top:bg-background-50 not-top:shadow-b-sm"
  x-bind:class="{'headroom--unpinned': !$store.scroll.pin, 'headroom--pinned': $store.scroll.pin, 'headroom--not-top': !$store.scroll.start}"
  x-bind:style="{transform: !$store.scroll.pin & !$store.scroll.start ? 'translateY(calc(var(--header-height) * -0.625))' : ''}">
  <div class="w-full flex justify-center lg:justify-between items-center px-header" style="height: calc(var(--header-height) * 0.625);">
    <?php get_template_part('template-parts/headers/partials/logo'); ?>
    <?php get_template_part('template-parts/headers/partials/search');?>
  </div>

  <div class="bg-text-50 w-full flex justify-center lg:justify-between items-center px-header" style="height: calc(var(--header-height) * 0.375);">
    <?php get_template_part('template-parts/headers/partials/menu'); ?>

    <div class="flex justify-center lg:justify-end items-center">
      <?php get_template_part('template-parts/headers/partials/trigger', 'categories'); ?>
      <span class="lg:hidden"><?php get_template_part('template-parts/headers/partials/trigger', "search"); ?></span>
      <?php get_template_part('template-parts/headers/partials/trigger', "account"); ?>
      <?php get_template_part('template-parts/headers/partials/trigger', 'cart-alt'); ?>
      <span class="lg:hidden"><?php get_template_part('template-parts/headers/partials/trigger', 'menu'); ?></span>
    </div>
  </div>
</header>