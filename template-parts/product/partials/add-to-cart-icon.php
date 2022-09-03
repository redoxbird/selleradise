<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
    extract($args);
}

if (!isset($product->id)) {
    global $product;
}

if (!$product) {
    return;
}

if (!$product->managing_stock() && !$product->is_in_stock()) {
    get_template_part('template-parts/product/partials/out-of-stock', null, ["product" => $product]);
    return;
}

?>

<?php if ($product->get_type() == 'simple' && $product->is_in_stock() && (class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode()) === false) : ?>

    <a x-data="addToCart({
            product: {
                id: <?php echo esc_html($product->get_ID()) ?>,
                ajax_add_to_cart_endpoint: '<?php echo esc_url(WC_AJAX::get_endpoint('add_to_cart')) ?>',
                name: '<?php echo esc_html($product->get_title()) ?>',
            }
        })"
        class="text-xs" 
        href="<?php echo esc_url($product->add_to_cart_url()) ?>" x-bind:class="[isInCart() ? 'buttonIcon--secondary p-3' : 'buttonIcon--secondary-outline p-3']" x-on:click.prevent="addToCart($event)">
        <span class="flex justify-center items-center w-5 h-5" x-show="!loading && !isInCart()">
            <?php echo selleradise_svg(selleradise_get_icon($product->get_type())); ?>
        </span>
        <span class="flex justify-center items-center w-5 h-5" x-show="isInCart()">
            <?php echo selleradise_svg("tabler-icons/eye"); ?>
        </span>
        <span class="flex justify-center items-center w-5 h-5" x-show="loading">
           <?php echo selleradise_svg("loader/simple"); ?>
        </span>
    </a>

<?php else :

    echo apply_filters(
        'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
        sprintf(
            '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
            esc_url($product->add_to_cart_url()),
            esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
            esc_attr(isset($args['class']) ? $args['class'] : 'buttonIcon--secondary-outline p-3'),
            isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
            selleradise_svg(selleradise_get_icon($product->get_type()))
        ),
        $product,
        $args
    );

?>

<?php endif; ?>