<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

?>

<div x-bind:class="{'xyz-in': inView}" id="post-<?php the_ID();?>" <?php post_class("selleradise_postCard--default-sticky md:col-span-full lg:col-span-2 flex justify-start flex-wrap flex-col-reverse md:flex-row rounded-2xl border-1 border-solid border-gray-200 p-3 overflow-hidden");?>>

    <div class="pt-8 px-4 pb-4 flex-1 flex justify-start items-start flex-col flex-wrap w-full md:p-4 md:w-3/5">
        <h2 class="m-0 text-xl">
            <?php get_template_part('template-parts/post/partials/title', null, ["type" => "default"]);?>
        </h2>

        <?php get_template_part('template-parts/post/partials/categories', null, ["type" => "default"]);?>

        <div class="text-sm my-4 selleradise_prose">
            <?php echo get_the_excerpt(); ?>
        </div>

        <?php get_template_part('template-parts/post/partials/author', 'minimal', ["type" => "default"]);?>
    </div>

    <?php get_template_part('template-parts/post/partials/image', null, ["classes" => "w-full md:w-2/5 h-88 rounded-2xl overflow-hidden"]);?>

</div><!-- #post-## -->
