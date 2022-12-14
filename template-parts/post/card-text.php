<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$class = 'selleradise_postCard--default h-auto bg-background-900 text-text-900 flex justify-start item-start flex-col flex-wrap rounded-2xl border-1 border-solid border-gray-200 p-8 overflow-hidden';

if(isset($classes) && $classes) {
  $class .= $classes;
}

?>

<div x-bind:class="{'xyz-in': inView}" id="post-<?php the_ID(); ?>" <?php post_class($class); ?> >
    
  <h2 class="text-md m-0 w-full">
    <?php get_template_part('template-parts/post/partials/title', null);?>
  </h2> 
  <?php get_template_part('template-parts/post/partials/categories', null);?>
  <div class="text-sm w-full mt-4">
    <?php echo get_the_excerpt(); ?>
  </div>
  <?php get_template_part('template-parts/post/partials/author', 'minimal'); ?>
    
</div><!-- #post-## -->
