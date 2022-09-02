<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if ('post' !== get_post_type()) {
    return;
} 

?>

<h2 class="m-0 text-md">
    <a class="text-text-900 hover:underline hover:text-main-900 break-all" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
        <?php echo esc_html( get_the_title() ); ?>
    </a>
</h2>
