<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<footer
  id="colophon"
  class="selleradise_footer--minimal flex justify-center lg:justify-between items-center flex-wrap relative border-0 border-t-1 border-solid border-text-50 bg-background-900 text-text-900 w-full px-page py-10 h-auto z-10"
  role="contentinfo">
    <?php get_template_part('template-parts/footers/partials/logo');?>

    <?php get_template_part('template-parts/footers/partials/menu');?>

    <p class="text-xs font-semibold text-text-700">
        <?php get_template_part('template-parts/footers/partials/notice');?>
    </p>

    <?php get_template_part('template-parts/footers/partials/back-to-top');?>

</footer><!-- #colophon -->