<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if (!class_exists('WooCommerce')) {
  return;
}

if ($args) {
  extract($args);
}

?>

<div
  class="selleradise_MiniCart"
  x-cloak
  x-data
  x-trap="$store.miniCart.isOpen()"
  x-on:keydown.esc.window="$store.miniCart.close()">
  <div x-cloak class="selleradise_MiniCart__inner transition ease-out duration-300" x-show="
      selleradiseData.isWooCommerce &&
      $store.miniCart.state != 'hidden'
    " x-transition.scale.opacity>
    <div class="selleradise_MiniCart__head">
      <p class="selleradise_MiniCart__headCount" x-show="$store.miniCart.isNotEmpty()" x-html="$store.miniCart.title"></p>
      <button class="button--close buttonIcon--secondary-outline" x-on:click="$store.miniCart.close()" x-ref="closeBtn">
        <?php echo selleradise_svg('tabler-icons/x') ?>
      </button>
    </div>

    <template x-if="$store.miniCart.isNotEmpty()">
      <ul class="selleradise_MiniCart__items" xyz="fade stagger-1 down-4 duration-4">
        <template x-for="(item, index) in $store.miniCart.items" x-bind:key="item.key">
          <li class="selleradise_MiniCart__item xyz-in">
            <a x-bind:href="item.product.link" class="selleradise_MiniCart__itemImage" x-html="item.product.image ? item.product.image : false"></a>

            <div class="selleradise_MiniCart__itemContent">
              <p class="selleradise_MiniCart__itemName">
                <a x-bind:href="item.product.link" x-html="item.product.name">
                </a>
              </p>

              <p class="selleradise_MiniCart__itemPrice" x-html="item.product.price"></p>

              <div class="selleradise_MiniCart__itemQuantity">
                <button x-bind:class="
                    item.quantity > 1
                      ? 'selleradise_MiniCart__decreaseQuantity'
                      : 'selleradise_MiniCart__removeItem'
                  " x-on:click.prevent="$store.miniCart.decreaseQuantity(index)">
                  <span class="flex justify-center items-center w-5" x-show="item.quantity > 1"><?php echo selleradise_svg('tabler-icons/minus') ?></span>
                  <span class="flex justify-center items-center w-5" x-show="item.quantity <= 1"><?php echo selleradise_svg('tabler-icons/trash') ?></span>
                </button>

                <span class="selleradise_MiniCart__itemQuantityCount" x-text="item.quantity"></span>

                <button class="selleradise_MiniCart__increaseQuantity" x-on:click.prevent="$store.miniCart.increaseQuantity(index)">
                  <?php echo selleradise_svg('tabler-icons/plus') ?>
                </button>
              </div>
            </div>
          </li>
        </template>
      </ul>
    </template>

    <div class="selleradise_MiniCart__foot" x-show="$store.miniCart.isNotEmpty()">
      <div class="selleradise_MiniCart__footActions">
        <a x-bind:href="selleradiseData.cartURL" class="selleradise_button--secondary-outline">
          <?php esc_attr_e('Edit Cart', '[TEXT_DOMAIN]'); ?>
        </a>
        <a x-bind:href="selleradiseData.checkoutURL" class="selleradise_button--primary">
          <?php esc_attr_e('Checkout', '[TEXT_DOMAIN]'); ?>
          <span class="selleradise_MiniCart__footCartTotal" x-html="$store.miniCart.total"></span>
        </a>
      </div>
    </div>

    <div class="selleradise_MiniCart__loader" x-show="$store.miniCart.state == 'updating'">
      <?php echo selleradise_svg('loader/simple') ?>
    </div>

    
    <div x-show="$store.miniCart.isEmpty()" class="w-full flex justify-center items-center flex-col text-center">
      <div class="flex justify-center items-center w-24 h-auto mb-5 p-2 children:w-full">
        <?php echo selleradise_svg('misc/empty-state') ?>
      </div>
      <h2 class="text-xl mb-2">
        <?php echo esc_html__('Your cart is empty.', '[TEXT_DOMAIN]'); ?>
      </h2>
      <p class="text-sm text-gray-600">
        <?php echo esc_html__('Looks like you have not added any product to your cart yet.', '[TEXT_DOMAIN]'); ?>
      </p>
    </div>

  </div>

  <div class="overlay" x-show="$store.miniCart.state != 'hidden'" x-on:click="$store.miniCart.close()" x-transition.opacity></div>
</div>