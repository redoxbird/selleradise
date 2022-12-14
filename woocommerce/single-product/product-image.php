<?php

/**
 * Single Product Image
 * 
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined('ABSPATH') || exit;

global $product;

$post_thumbnail_id = $product->get_image_id();
$gallery_image_ids = $product->get_gallery_image_ids() ?? [];

array_unshift($gallery_image_ids, $post_thumbnail_id);

?>


<div  
	class="selleradise_single_product__images">

	<div x-ref="images" class="selleradise_single_product__images-slider embla">
		<ul class="embla__container">
			<?php
			foreach ($gallery_image_ids as $image_id) :
				$url = wp_get_attachment_url($image_id);

				if (!$url) {
					continue;
				}

				$image = wp_get_attachment_image_src($image_id, 'large');
				$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
				$image_ratio = (int) $image[2] / (int) $image[1];
			?>

				<li
				  class="selleradise_single_product__images-slide embla__slide"
				  data-size-w="<?php echo esc_attr($image[1]); ?>"
				  data-size-h="<?php echo esc_attr($image[2]); ?>"
				  <?php if (get_option('woocommerce_thumbnail_cropping') == 'uncropped'): ?>
						style="--product-image-ratio: <?php echo esc_attr($image_ratio); ?>;"
				  <?php endif;?>
					>
					<img
					  class="w-full h-full object-cover"
					  src="<?php echo esc_url(wc_placeholder_img_src()); ?>"
						x-lazy:src="<?php echo esc_url($image[0]); ?>"
					  alt="<?php echo esc_attr($image_alt); ?>">
					<a href="<?php echo esc_url($url); ?>"></a>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php if(count($gallery_image_ids) > 1): ?>
			<div class="flex justify-center items-center absolute bottom-2 left-1/2 -translate-x-1/2 bg-white border-1 border-solid border-gray-300 rounded-full text-gray-600">
				<button class="selleradise_slider__nav--previous" x-on:click="embla?.scrollPrev()"><?php echo selleradise_svg('tabler-icons/chevron-left') ?></button>
				<button class="selleradise_slider__nav--next" x-on:click="embla?.scrollNext()"><?php echo selleradise_svg('tabler-icons/chevron-right') ?></button>
			</div>
		<?php endif; ?>
	</div>

	<?php if(count($gallery_image_ids) > 1): ?>
		<div x-ref="thumbs" class="embla my-4">
			<div class="embla__container gap-4">
				<?php
				foreach ($gallery_image_ids as $index => $image_id) :
					$thumbnail = wp_get_attachment_image_src($image_id, 'thumbnail');

					if (!$thumbnail) {
						continue;
					}

				?>
					<button
						data-index="<?php echo esc_attr( $index ); ?>"
						class="w-2/5 md:w-1/4 h-40 relative flex-shrink-0 rounded-2xl overflow-hidden border-none"
						x-bind:class="{'transition-all opacity-50': isInView(<?php echo esc_attr($index); ?>) }"
						x-on:click="onThumbClick(<?php echo esc_attr($index); ?>)"
						>
						<img
							class="absolute inset-0 !max-w-none w-full !h-full object-cover"
							x-lazy:src="<?php echo esc_url($thumbnail[0]); ?>"
							src="<?php echo esc_url(wc_placeholder_img_src()); ?>"
							alt="">
					</button>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>


</div>