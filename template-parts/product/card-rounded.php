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


$class = 'selleradise_productCard selleradise_productCard--rounded ';

if (isset($classes) && $classes) {
    $class .= $classes;
}


?>

<li
  x-bind:class="{'xyz-in': inView}"
  class="<?php echo esc_attr($class); ?> flex flex-col justify-start items-start rounded-2xl bg-background-900 text-text-900 border-1 border-solid border-gray-200 hover:border-gray-300 p-5 overflow-hidden transition-all">

  <?php do_action('woocommerce_before_shop_loop_item');?>
  
  <?php do_action('woocommerce_before_shop_loop_item_title');?>

  <h3 class="text-lg md:text-sm m-0 flex-grow w-full leading-normal">
      <a class="flex-grow text-text-900 text-inherit hover:text-main-900 hover:underline" href="<?php echo esc_url($product->get_permalink()); ?>">
          <?php echo esc_attr( $product->get_name() ) ?>
      </a>
  </h3>

  <?php do_action('woocommerce_after_shop_loop_item_title');?>
  
  <a x-init="$el.style.setProperty('--width', $el.offsetWidth + 'px')" href="<?php echo esc_url($product->get_permalink()); ?>" class="w-60 h-60 md:w-44 md:h-44 rounded-full flex justify-center items-center overflow-hidden mx-auto mt-6 mb-4">
    <?php get_template_part('template-parts/product/partials/image', "single", ["product" => $product, "image" => $product->get_image_id()]);?>
  </a>

  <div class="text-md flex-grow relative w-full">

    <?php get_template_part('template-parts/product/partials/categories', null, ["product" => $product, "classes" => "mt-1 mr-2"]); ?>

    <div class="flex justify-between items-center mt-1">
      <div class="selleradise_productCard__price text-lg md:text-sm font-semibold">
        <?php echo wp_kses_post( $product->get_price_html() ); ?>
      </div>

      <?php get_template_part('template-parts/product/partials/add-to-cart', 'icon', ["product" => $product]); ?>
    </div>

  </div>

  <?php do_action('woocommerce_after_shop_loop_item');?>

</li>