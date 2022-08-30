<?php if (class_exists('WooCommerce')) : ?>
  <button
    class="selleradiseHeader__trigger selleradiseHeader__trigger--category"
    x-tooltip="triggerCategoryTooltip"
    x-on:click.prevent="$store.mobileMenu.open('categories')">
    <span id="triggerCategoryTooltip" role="tooltip" class="selleradise_tooltip">
      <?php esc_html_e('Categories', '[TEXT_DOMAIN]'); ?>
    </span>
    <?php echo selleradise_svg('tabler-icons/category-2') ?>
  </button>
<?php endif; ?>