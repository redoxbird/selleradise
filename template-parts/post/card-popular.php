<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<div x-data id="post-<?php the_ID();?>" <?php post_class("selleradise_postCard--default relative h-auto bg-background-900 text-text-900 self-stretch flex justify-start item-start flex-col flex-wrap rounded-2xl overflow-hidden transition-all");?> >
    <?php get_template_part('template-parts/post/partials/image', null);?>

    <div
      class="absolute bg-background-700 bottom-4 left-4 right-4 py-4 px-6 rounded-2xl flex-1 flex justify-start items-start flex-col flex-wrap"
      style="backdrop-filter: blur(0.25rem)">
      <?php get_template_part('template-parts/post/partials/title', null);?>
        <?php get_template_part('template-parts/post/partials/author', 'minimal'); ?>
    </div>
</div><!-- #post-## -->
