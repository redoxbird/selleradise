<?php
/**
 * Photoswipe markup
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>



<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="pswp__bg"></div>
	<div class="pswp__scroll-wrap">
		<div class="pswp__container">
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
		</div>
		<div class="pswp__ui pswp__ui--hidden">
			<div class="pswp__top-bar">
				<div class="pswp__counter"></div>
				<div class="pswp__controls">
					<button class="pswp__button pswp__button--zoom" aria-label="<?php esc_attr_e( 'Zoom in/out', '[TEXT_DOMAIN]' ); ?>">
						<?php echo selleradise_svg('tabler-icons/zoom-in') ?>
					</button>
					<button class="pswp__button pswp__button--fs" aria-label="<?php esc_attr_e( 'Toggle fullscreen', '[TEXT_DOMAIN]' ); ?>">
						<?php echo selleradise_svg('tabler-icons/arrows-maximize') ?>
					</button>
					<button class="pswp__button pswp__button--share" aria-label="<?php esc_attr_e( 'Share', '[TEXT_DOMAIN]' ); ?>">
						<?php echo selleradise_svg('tabler-icons/share') ?>
					</button>
					<button class="pswp__button pswp__button--close" aria-label="<?php esc_attr_e( 'Close (Esc)', '[TEXT_DOMAIN]' ); ?>">
						<?php echo selleradise_svg('tabler-icons/x') ?>
					</button>
				</div>
				<div class="pswp__preloader">
					<div class="pswp__preloader__icn">
						<div class="pswp__preloader__cut">
							<div class="pswp__preloader__donut"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
				<div class="pswp__share-tooltip"></div>
			</div>
			<button class="pswp__button pswp__button--arrow--left" aria-label="<?php esc_attr_e( 'Previous (arrow left)', '[TEXT_DOMAIN]' ); ?>">
				<?php echo selleradise_svg('tabler-icons/chevron-left') ?>
			</button>
			<button class="pswp__button pswp__button--arrow--right" aria-label="<?php esc_attr_e( 'Next (arrow right)', '[TEXT_DOMAIN]' ); ?>">
				<?php echo selleradise_svg('tabler-icons/chevron-right') ?>
			</button>
			<div class="pswp__caption">
				<div class="pswp__caption__center"></div>
			</div>
		</div>
	</div>
</div>
