<?php

/**
 * Cart Page
 * 
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */


defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); 

?>

<?php get_template_part('template-parts/components/breadcrumb');?>

<div class="selleradise_page-cart flex justify-start items-stretch flex-wrap w-full pb-20 text-text-900">

	<form class="woocommerce-cart-form flex-1 text-md overflow-hidden rounded-lg" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

		<?php do_action( 'woocommerce_before_cart_table' ); ?>

		<ul class="list-none m-0 p-0 pr-1 mt-2 grid grid-cols-1 md:grid-cols-2 gap-4 cart woocommerce-cart-form__contents" xyz="fade stagger-1 down-4 duration-4">
			<?php do_action('woocommerce_before_cart_contents'); ?>

			<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ):
					$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
					$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ):
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>

				
				<li class="border-1 border-solid border-text-200 rounded-xl overflow-hidden cart_item xyz-in">

					<div class="w-full bg-text-50 px-4 py-3 text-sm">
						<ul class="list-none m-0 p-0 flex justify-start items-center gap-6">
							<li class="flex flex-col">
								<span class="mb-1 text-xs"><?php esc_html_e('Subtotal', '[TEXT_DOMAIN]') ?></span>
								<span class="font-semibold"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok. ?></span>
							</li>
							<li class="flex flex-col">
								<span class="mb-1 text-xs"><?php esc_html_e('Stock', '[TEXT_DOMAIN]') ?></span>
								<span class="font-semibold uppercase"><?php echo $_product->get_stock_status(); ?></span>
							</li>
						</ul>
					</div>

					<div class="p-4 bg-background-900 border-t-[0.05rem] border-text-200">
						<div class="flex justify-start items-start">
							<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

								if ( ! $product_permalink ) {
									echo wp_kses_post( $thumbnail ); // PHPCS: XSS ok.
								} else {
									printf( '<a href="%s" class="selleradise-background-image rounded-xl overflow-hidden w-20 h-20 flex-shrink-0">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
								}
							?>

							<div class="ml-4 flex-grow">
								<h2 class="text-md m-0">
									<?php
										if ( ! $product_permalink ) {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
										} else {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="text-text-900 hover:underline hover:text-main-900">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
										}

										do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

										// Meta data.
										echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

										// Backorder notification.
										if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', '[TEXT_DOMAIN]' ) . '</p>', $product_id ) );
										}
									?>
								</h2>

								<?php get_template_part('woocommerce/cart/variation-info', null, ['_product' => $_product]);?>
							</div>
						</div>

						<div class="flex justify-start items-center mt-3 w-full flex-wrap">

							<div class="product-quantity">
								<?php
									if ( $_product->is_sold_individually() ) {
										$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
									} else {
										$product_quantity = woocommerce_quantity_input(
											array(
												'input_name'   => "cart[{$cart_item_key}][qty]",
												'input_value'  => $cart_item['quantity'],
												'max_value'    => $_product->get_max_purchase_quantity(),
												'min_value'    => '0',
												'product_name' => $_product->get_name(),
											),
											$_product,
											false
										);
									}

									echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
								?>
							</div>

							<span class="w-4 mx-3 h-auto flex justify-center items-center text-text-900 opacity-50">
								<?php echo selleradise_svg('tabler-icons/x'); ?>
							</span>

							<span class="font-semibold text-sm">
								<?php
									echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
								?>
							</span>

							<div class="pl-3 ml-auto">
								<?php
									echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a href="%s" class="mt-auto text-xs font-semibold text-text-900 bg-gray-50 border-gray-200 border-1 border-solid px-3 py-1 rounded-full hover:bg-red-500 hover:text-white" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											esc_html__( 'Remove this item', '[TEXT_DOMAIN]' ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() ),
											esc_html__( 'Remove', '[TEXT_DOMAIN]' )
										),
										$cart_item_key
									);
								?>
							</div>
						</div>

					</div>
						
				</li>

				<?php do_action('woocommerce_cart_contents');?>

				<tr>

				</tr>

				<?php do_action('woocommerce_after_cart_contents');?>

			
			<?php endif; endforeach; ?>
		</ul>

		<div class="actions mt-4 w-full">
			<div class="update-action-wrap flex justify-end w-full">
				<button type="submit" class="selleradise_button--primary" name="update_cart" value="<?php esc_attr_e( 'Update cart', '[TEXT_DOMAIN]' ); ?>"><?php esc_html_e( 'Update cart', '[TEXT_DOMAIN]' ); ?></button>
			</div>

			<?php if ( wc_coupons_enabled() ) { ?>
				<div class="coupon flex justify-start items-start flex-wrap flex-col w-full relative py-4">
					<label for="coupon_code" class="mt-4 font-semibold"><?php esc_html_e( 'Coupon:', '[TEXT_DOMAIN]' ); ?></label> 
					<input type="text" name="coupon_code" class="input-text w-full grow border-none mt-2 px-4 mb-4" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', '[TEXT_DOMAIN]' ); ?>" /> 
					<button type="submit" class="selleradise_button--secondary ml-auto" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', '[TEXT_DOMAIN]' ); ?>">
						<?php esc_attr_e( 'Apply coupon', '[TEXT_DOMAIN]' ); ?>
					</button>
					<?php do_action( 'woocommerce_cart_coupon' ); ?>
				</div>
			<?php } ?>

			<?php do_action( 'woocommerce_cart_actions' ); ?>

			<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
		</div>
		<?php do_action( 'woocommerce_after_cart_table' ); ?>
	</form>

	<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

	<div class="cart-collaterals">
		<?php
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10
			 */
			do_action( 'woocommerce_cart_collaterals' );
		?>
	</div>

	<?php do_action( 'woocommerce_after_cart' ); ?>

</div>

