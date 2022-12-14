<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

$class = 'selleradise_postCard--default h-auto bg-background-900 text-text-900 flex justify-start item-start flex-col flex-wrap rounded-2xl border-1 border-solid border-gray-200 p-2 overflow-hidden';

if(isset($classes) && $classes) {
    $class .= $classes;
}

?>

<div x-bind:class="{'xyz-in': inView}" id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
    <?php get_template_part('template-parts/post/partials/image', null);?>
    
    <div class="p-4 w-full flex-1 flex justify-start items-start flex-col flex-wrap">
        <h2 class="text-md m-0 w-full">
            <?php get_template_part('template-parts/post/partials/title', null);?>
        </h2> 
        <?php get_template_part('template-parts/post/partials/categories', null);?>
        <?php get_template_part('template-parts/post/partials/author', 'minimal'); ?>
    </div>
</div><!-- #post-## -->
