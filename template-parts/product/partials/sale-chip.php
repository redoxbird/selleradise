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


if (!$product->is_on_sale() || !$product->get_sale_price() || !$product->get_regular_price()) {
    return;
}

$percentage = (int) round(($product->get_regular_price() - (float) $product->get_sale_price()) / (float) $product->get_regular_price() * 100);

?>

<span class="<?php echo isset($classes) ? esc_attr($classes) : null ?>">
    <?php echo sprintf(esc_html__('%s%% OFF', '[TEXT_DOMAIN]'), $percentage); ?>
</span>