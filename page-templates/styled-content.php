<?php
/**
 * Template Name: Styled Content
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package Selleradise
 */
get_header();

if (have_posts()): while (have_posts()): the_post(); ?>

    <main>
      <div class="w-full h-auto bg-text-50 px-page py-20 text-center flex flex-col justify-center items-center gap-4 border-0 border-b-1 border-solid border-text-100">
        <h1 class="text-5xl font-semibold m-0 leading-tight"><?php the_title(); ?></h1>
      </div>
      <div class="px-page my-16 selleradise_prose">
        <?php the_content(); ?>
      </div>
    </main>

<?php endwhile; endif;

get_footer();
