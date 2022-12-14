<?php // [REMOVE_FILE_IN_LITE]

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


$class = 'selleradise_productCard selleradise_productCard--minimal ';

if (isset($classes) && $classes) {
    $class .= $classes;
}


?>

<li
  x-bind:class="{'xyz-in': inView}"
  class="<?php echo esc_attr($class); ?> flex flex-col justify-start items-start overflow-hidden">

    <?php do_action('woocommerce_before_shop_loop_item');?>
   
   <div
     x-init="$el.style.setProperty('--width', $el.offsetWidth + 'px')"
     href="<?php echo esc_url($product->get_permalink()); ?>"
     class="selleradise_productCard__image-outer w-full">
        <?php get_template_part('template-parts/product/partials/image', "single", ["product" => $product, "image" => $product->get_image_id()]);?>
    </div>

    <div class="text-md flex flex-col px-2 py-5 flex-grow relative justify-start items-start w-full">
      <?php do_action('woocommerce_before_shop_loop_item_title');?>

      <h3 class="text-xs m-0 flex-grow w-full leading-normal">
          <a class="flex-grow text-text-900 text-inherit hover:text-main-900 hover:underline"  href="<?php echo esc_url($product->get_permalink()); ?>">
              <?php echo esc_attr( $product->get_name() ) ?>
          </a>
      </h3>

      <?php do_action('woocommerce_after_shop_loop_item_title');?>

      <div class="selleradise_productCard__price text-xs opacity-75 font-medium mt-1">
          <?php echo wp_kses_post( $product->get_price_html() ); ?>
      </div>
    </div>

    <?php do_action('woocommerce_after_shop_loop_item');?>

</li>