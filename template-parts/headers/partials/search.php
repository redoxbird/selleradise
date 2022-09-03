<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

$header_type = get_theme_mod('header_type', 'default');
$ajax_type = class_exists('DGWT_WC_Ajax_Search') ? "fibosearch" : "native";

?>

<form
  action="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>"
  method="get"
  x-data="searchBar({
    type: '<?php echo esc_attr(isset($ajax_type) && $ajax_type ? $ajax_type : 'native') ?>',
    headerType: '<?php echo esc_attr($header_type); ?>'
  })"
  x-on:start-search.window="start()"
  x-on:click.outside="stop()"
  x-bind:data-state="state"
  role="search"
  x-ref="searchForm"
  class="selleradiseHeader__searchForm flex-grow flex justify-center items-center"
  x-bind:class="[isModal() ? 'selleradiseHeader__searchForm--overlay' : 'relative']"
  x-trap.noreturn="isModal() && show()"
  x-show="isModal() ? show() : true"
  x-transition:enter="transition ease-out-expo duration-500"
  x-transition:enter-start="opacity-0 translate-y-16"
  x-transition:enter-end="opacity-100 translate-y-0"
  x-transition:leave="transition ease-out-expo duration-300"
  x-transition:leave-start="opacity-100 translate-y-0"
  x-transition:leave-end="opacity-0 translate-y-16"
  x-on:keydown.esc.window="stop()"
  >

  <template x-teleport="header">
    <div x-show="isModal() && show()" x-transport="body" class="overlay z-1000" x-on:click="close()" x-transition.opacity></div>
  </template>

  <label class="flex">
    <span class="sr-only"><?php esc_html_e("Search for products here...", '[TEXT_DOMAIN]'); ?></span>
    <input
      type="text"
      x-bind:value="keyword"
      x-on:input="start(); handleInputChange($event)"
      x-on:keydown="handelInputKeyDown($event)"
      class="searchField h-full"
      x-ref="input"
      name="s"
      autocomplete="off"
      maxlength="50"
      minlength="2"
      placeholder="<?php esc_attr_e("Search for products here...", '[TEXT_DOMAIN]'); ?>" 
    />
    <button 
      x-ref="searchClearButton" 
      class="clear h-full border-none inline-flex justify-center items-center bg-transparent" 
      x-show="keyword && keyword != ''" 
      x-tooltip="headerSearchBarClearButtonTooltip" 
      x-on:click.prevent="clear()">
      <span id="headerSearchBarClearButtonTooltip" role="tooltip" class="selleradise_tooltip">
        <?php esc_html_e('Clear', '[TEXT_DOMAIN]'); ?>
      </span>
      <?php echo selleradise_svg('tabler-icons/x'); ?>
    </button>
  </label>

  <button type="submit" x-ref="searchSubmitButton" x-on:blur="handleSubmitBlur()" v-on:keydown.tab.exact="send('STOP')" x-on:click="handleEnterPress($event)" x-tooltip="headerSearchBarSubmitButtonTooltip">
    <span id="headerSearchBarSubmitButtonTooltip" role="tooltip" class="selleradise_tooltip">
      <?php esc_attr_e("Submit", '[TEXT_DOMAIN]'); ?>
    </span>
    <span class="inlineSVGIcon" x-show="state === 'searching'">
      <?php echo selleradise_svg('loader/simple'); ?>
    </span>
    <span class="inlineSVGIcon" x-show="state !== 'searching'">
      <?php echo selleradise_svg('tabler-icons/search'); ?>
    </span>
  </button>

  <div
    x-show="state === 'found'"
    x-transition
    class="selleradiseHeader__searchResults mt-4 rounded-lg"
    x-ref="results"
    x-on:keydown.down.prevent="$focus.wrap().next()"
    x-on:keydown.up.prevent="$focus.wrap().previous()"
    x-on:keydown.esc="$focus.focus($refs.input)"
    x-cloak>
    <ul class="selleradiseHeader__searchResults-inner">
      <li x-show="terms && terms.length > 0">
        <ul class="selleradiseHeader__searchResults-suggestions--categories">
          <template x-for="term in terms">
            <li>
              <a x-bind:href="getLink(term, 'term')" x-text="getName(term, 'term')"></a>
            </li>
          </template>
        </ul>
      </li>

      <span class="hidden w-16 h-16 mr-2 rounded-xl overflow-hidden"></span>

      <li x-show="products && products.length > 0">
        <ul class="selleradiseHeader__searchResults-suggestions--products">
          <template x-for="product in products">
            <li class="w-full">
              <a class="w-full flex justify-start items-start" x-bind:href="getLink(product, 'product')" >
                <div class="w-16 h-16 mr-4 rounded-xl overflow-hidden flex justify-center items-center" x-show="getImage(product)" x-html="getImage(product)"></div>
                <div>
                  <h2 class="text-sm font-semibold" x-text="getName(product, 'product')"></h2>
                  <span x-show="getPrice(product)" class="mt-2 opacity-75 text-sm" x-html="getPrice(product)"></span>
                </div>
              </a>
            </li>
          </template>
        </ul>
      </li>
    </ul>
  </div>
</form>