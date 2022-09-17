<?php

if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;
global $wp_query;

$shop_page_display = get_option('woocommerce_shop_page_display', false);
$category_archive_display = get_option('woocommerce_category_archive_display', false);
$location = get_theme_mod('filters_location', 'sidebar');
$filters_to_show = get_theme_mod('shop_filters_to_show', ['price', 'categories', 'attributes', 'tags']);
$submit_on_change = get_theme_mod('shop_filters_submit_on_change', false);
$search_params = array();

parse_str($_SERVER['QUERY_STRING'], $search_params);


if (is_shop() && $shop_page_display === 'subcategories' && !selleradise_query_has_filters(array_keys($wp_query->query_vars))) {
    return;
}

if (is_product_category() && $category_archive_display === 'subcategories') {

    $child_categories = get_terms([
        'child_of' => $wp_query->queried_object->term_id,
        'type' => $wp_query->post->post_type,
        'taxonomy' => $wp_query->queried_object->taxonomy,
    ]);

    if (!empty($child_categories)) {
        return;
    }
}

$categories = selleradise_get_product_categories_tree();

$min_price = isset($search_params['min_price']) && $search_params['min_price'] ? $search_params['min_price'] : 0;
$max_price = isset($search_params['max_price']) && $search_params['max_price'] ? $search_params['max_price'] : 0;

?>

<div 
    x-data="shopFilters({
        highestPrice: <?php echo esc_attr(selleradise_get_shop_max_price()); ?>,
        min_price: <?php echo esc_attr($min_price); ?>,
        max_price: <?php echo esc_attr($max_price); ?>,
        searchParams: '<?php echo esc_attr($_SERVER["QUERY_STRING"]) ?>',
        submitOnChange: <?php echo wp_json_encode($submit_on_change) ?>,
        type: '<?php echo esc_attr($location); ?>'
    })">

    <?php if($location === "offscreen"): ?>
        <div x-show="show()" class="overlay" x-on:click="close()" x-transition:enter="xyz-in" x-transition:leave="xyz-out" xyz="fade duration-2"></div>
    <?php else: ?>
        <div x-show="isSmall && show()" class="overlay" x-on:click="close()" x-transition:enter="xyz-in" x-transition:leave="xyz-out" xyz="fade duration-2"></div>
    <?php endif; ?>

    <div 
        x-on:open-shop-filters.window="open();" 
        x-on:click.outside="close()" 
        x-show="show()"  
        x-bind:class="['selleradise_shop__filters',className()]"
        x-transition:enter="xyz-in"
        x-transition:leave="xyz-out"
        xyz="fade right-5 duration-2">

        <form method="get" x-ref="form" x-on:change="updateFormData();" action="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink('shop') : "") ?>">
            <?php if(!$submit_on_change): ?>
                <div class="flex justify-between items-center mb-10" x-show="isChanged" x-transition x-cloak>
                    <button type="submit" class="selleradise_button--primary">
                        <?php esc_html_e('Apply Filters', '[TEXT_DOMAIN]') ?>
                    </button>
                    <a
                      class="flex justify-start items-center ml-auto text-sm font-semibold text-text-900"
                      href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink('shop') : "") ?>">
                        <span class="w-4 h-4 mr-1"><?php echo selleradise_svg('tabler-icons/x'); ?></span>
                        <?php esc_html_e('Clear', '[TEXT_DOMAIN]') ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php if(isset($search_params['s']) && $search_params['s']): ?>
                <input type="hidden" name="s" value="<?php echo esc_attr($search_params['s']) ?>">
            <?php endif; ?>

            <?php if(in_array('price', $filters_to_show)): ?>
                <div class="selleradise_shop__filters-price">
                    <div class="selleradise_shop__filters-price-head">
                        <h3 class="selleradise_shop__filters-title">
                            <?php esc_html_e('Price', '[TEXT_DOMAIN]') ?>
                        </h3>
                        <div class="selleradise_shop__filters-price-values">
                            <span x-text="currencySymbol + fields.min_price"></span>
                            <span class="selleradise_shop__filters-price-values-divider"></span>
                            <span x-text="currencySymbol + fields.max_price"></span>
                        </div>
                    </div>

                    <div x-ref="priceSlider" class="selleradise_shop__filters-price-slider" id="selleradise_shop__filters-price-slider"></div>
                </div>
            <?php endif; ?>

            <?php if(in_array('categories', $filters_to_show)): ?>
                <div class="categories" v-if="hasCategories" name="selleradise_shop__filters-categories-input">
                    <h3 class="selleradise_shop__filters-title" key="selleradise_shop__filters-categories-title">
                        <?php esc_html_e('Categories', '[TEXT_DOMAIN]') ?>
                    </h3>

                    <?php
                        if ($categories && !empty($categories)) :
                            get_template_part(
                                "template-parts/pages/shop/partials/categories-checkbox-tree",
                                null,
                                ["items" => $categories, "level" => 1, "parent" => []]
                            );
                        endif;
                    ?>
                </div>
            <?php endif; ?>

            <?php if(in_array('attributes', $filters_to_show)): ?>
                <template x-for="attribute in data.attributes">
                    <div class="attributes">
                        <h3 class="selleradise_shop__filters-title" x-text="attribute.attribute_label"></h3>

                        <template x-for="value in attribute.attribute_values">
                            <div class="inputWrap" x-bind:class="[value.color ? 'inputWrap--color' : undefined]" x-bind:style="{
                            '--swatch-color': value.color
                                ? value.color
                                : 'rgba(color(text-rgb), 0.05)',
                            }">
                                <input x-bind:checked="isAttributeChecked(attribute.attribute_name, value.slug)" x-on:change="handleAttributeChange($event, attribute, value)" type="checkbox" x-bind:id="value.slug" x-bind:value="value.slug" />
                                <label x-bind:class="[value.color ? 'color' : undefined]" x-bind:for="value.slug" x-text="value.name"></label>
                            </div>
                        </template>
                    </div>
                </template>
            <?php endif; ?>

            <?php if(in_array('tags', $filters_to_show)): ?>
                <div class="attributes">
                    <h3 class="selleradise_shop__filters-title">Tags</h3> 
                    <template x-for="value in data.tags">
                        <div class="inputWrap">
                            <input x-bind:checked="isTagChecked(value.slug)" x-on:change="handleTagChange($event)" type="checkbox" x-bind:id="value.slug" x-bind:value="value.slug" />
                            <label x-bind:for="value.slug" x-text="value.name"></label>
                        </div>
                    </template>
                </div>
            <?php endif; ?>

            <?php if(!$submit_on_change): ?>
                <div class="flex justify-between items-center mt-4 mb-10" x-show="isChanged" x-transition x-cloak>
                    <button type="submit" class="selleradise_button--primary">
                        <?php esc_html_e('Apply Filters', '[TEXT_DOMAIN]') ?>
                    </button>
                    <a
                      class="flex justify-start items-center ml-auto text-sm font-semibold text-text-900"
                      href="<?php echo esc_url(function_exists("wc_get_page_permalink") ? wc_get_page_permalink('shop') : "") ?>">
                        <span class="w-4 h-4 mr-1"><?php echo selleradise_svg('tabler-icons/x'); ?></span>
                        <?php esc_html_e('Clear', '[TEXT_DOMAIN]') ?>
                    </a>
                </div>
            <?php endif; ?>

            <div>
                <input type="hidden" name="min_price" x-show="fields.min_price" x-bind:value="fields.min_price" value="<?php echo esc_attr($min_price); ?>" />
                <input type="hidden" name="max_price" x-show="fields.max_price" x-bind:value="fields.max_price" value="<?php echo esc_attr($max_price); ?>" />
                <input type="hidden" name="product_cat" x-show="fields.product_cat" x-bind:value="fields.product_cat" />
                <input type="hidden" name="product_tag" x-show="fields.product_tag" x-bind:value="fields.product_tag" />

                <template x-for="(values, key) in fields.attributes">
                    <input type="hidden" x-show="values?.length > 0" x-bind:name="'filter_' + key" x-bind:value="values" />
                </template>
            </div>
        </form>
    </div>
</div>