<?php
/**
 * Single Product title
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce/Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

the_title( '<h1 class="mt-2 mx-0 mb-0 text-5xl text-text-900 entry-title">', '</h1>' );
