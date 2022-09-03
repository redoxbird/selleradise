<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$class = 'selleradise_postCard--list h-auto bg-background-900 text-text-900 flex justify-start item-start rounded-2xl border-1 border-solid border-gray-200 p-2 overflow-hidden';

if(isset($classes) && $classes) {
    $class .= $classes;
}

?>

<div x-data id="post-<?php the_ID();?>" <?php post_class($class);?> >
  <?php get_template_part('template-parts/post/partials/image', null, ["type" => "list", "classes" => "w-44 !h-44 object-cover flex-shrink-0 rounded-2xl overflow-hidden"]);?>

   <div class="p-4">        
      <h2 class="text-md m-0 w-full">
        <?php get_template_part('template-parts/post/partials/title', null, ["type" => "list"]);?>
      </h2>
      <?php get_template_part('template-parts/post/partials/categories', null, ["type" => "list"]);?>
      <?php get_template_part('template-parts/post/partials/author', 'minimal', ["type" => "list"]); ?>
  </div>
</div><!-- #post-## -->
