<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<div x-bind:class="{'xyz-in': inView}" id="post-<?php the_ID();?>" <?php post_class("selleradise_postCard--default h-auto bg-background-900 text-text-900 flex justify-start item-start flex-col flex-wrap rounded-2xl border-1 border-solid border-gray-200 p-2 overflow-hidden hover:border-gray-300 transition-all");?> >
    <?php get_template_part('template-parts/post/partials/image', null);?>

    <h2 class="text-md m-0 pt-4 px-3 pb-1 w-full">
      <?php get_template_part('template-parts/post/partials/title', null);?>
    </h2>
</div><!-- #post-## -->
