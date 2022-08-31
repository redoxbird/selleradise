<?php

$prev_link = get_previous_post_link('%link');
$next_link = get_next_post_link('%link');

?>

<ul class="flex justify-between items-center flex-wrap lg:flex-nowrap gap-4 bg-background-900 my-4 w-full">
    <?php if($prev_link): ?>
        <li class="w-full lg:w-1/2 lg:flex-grow">
            <p class="flex justify-start items-center font-sm opacity-75 mb-1">
                <span class="w-3 h-auto mr-1">
                    <?php echo selleradise_svg('tabler-icons/chevron-left'); ?>
                </span> 
                <?php esc_html_e( 'Previous', '[TEXT_DOMAIN]' ); ?>
            </p>
            <span class="text-underline font-semibold">
                <?php echo previous_post_link('%link'); ?>
            </span>
        </li>
    <?php endif; ?>

    <?php if($next_link): ?>
        <li class="w-full lg:w-1/2 lg:flex-grow text-right">
            <p class="flex justify-end items-center font-sm opacity-75 mb-1">
                <?php esc_html_e('Next', '[TEXT_DOMAIN]');?> 
                <span class="w-3 h-auto ml-1">
                    <?php echo selleradise_svg('tabler-icons/chevron-right'); ?>
                </span>
            </p>
            <span class="text-underline font-semibold">
                <?php next_post_link('%link') ?>            
            </span>
        </li>
    <?php endif; ?>
</ul>
