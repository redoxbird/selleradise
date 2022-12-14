<?php

namespace THEME_NAMESPACE\Core;

/**
 * Tags.
 */
class Tags
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {
      
    }

    public static function posted_on()
    {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated hide" datetime="%3$s">%4$s</time>';
        }
        $time_string = sprintf($time_string,
            esc_attr(get_the_date('c')),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date('c')),
            esc_html(get_the_modified_date())
        );
        $posted_on = sprintf(
            esc_html('%s'),
            '<a class="flex justify-start items-center text-text-900 hover:underline" href="' . esc_url(get_permalink()) . '" rel="bookmark"><span class="flex justify-center items-center w-3 mr-1 h-auto">' .selleradise_svg('tabler-icons/calendar').'</span>'.$time_string . '</a>'
        );
     
        return "<span class='posted-on leading-none'>{$posted_on}</span>";
    }

    public static function entry_footer()
    {

        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', '[TEXT_DOMAIN]'));
            if ($categories_list && self::categorized_blog()) {
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', '[TEXT_DOMAIN]') . '</span>', $categories_list); // WPCS: XSS OK.
            }
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html__(', ', '[TEXT_DOMAIN]'));
            if ($tags_list) {
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', '[TEXT_DOMAIN]') . '</span>', $tags_list); // WPCS: XSS OK.
            }
        }
        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            /* translators: %s: post title */
            comments_popup_link(sprintf(wp_kses(__('Leave a Comment<span class="screen-reader-text"> on %s</span>', '[TEXT_DOMAIN]'), array('span' => array('class' => array()))), get_the_title()));
            echo '</span>';
        }
        edit_post_link(
            sprintf(
                /* translators: %s: Name of current post */
                esc_html__('Edit %s', '[TEXT_DOMAIN]'),
                the_title('<span class="screen-reader-text">"', '"</span>', false)
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
}
