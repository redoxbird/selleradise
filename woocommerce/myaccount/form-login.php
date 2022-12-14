<?php

/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 6.0.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form'); ?>

<div x-data="{active: 'login'}" x-init="window.location.hash === '#register' ? active = 'register' : active = 'login'" class="selleradise_account-forms">

	<div
	  x-show="active === 'login'"
	  class="selleradise_account-form selleradise_account-form--login"
	  x-transition:enter="xyz-in"
		xyz="fade down-5 duration-3"
	 >

		<h2 class="selleradise_account-form__title">
			<?php echo _e('Login', '[TEXT_DOMAIN]'); ?>
		</h2>

		<form class="woocommerce-form woocommerce-form-login login" method="post">
			<?php do_action('woocommerce_login_form_start'); ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php esc_html_e('Username or email address', '[TEXT_DOMAIN]'); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
																																																																																																																										?>
			</p>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php esc_html_e('Password', '[TEXT_DOMAIN]'); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
			</p>

			<?php do_action('woocommerce_login_form'); ?>

			<p class="rememberMe">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e('Remember me', '[TEXT_DOMAIN]'); ?></span>
				</label>

				<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>

				<button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php echo esc_attr(__('Log in', '[TEXT_DOMAIN]')); ?>">
					<?php esc_html_e('Log in', '[TEXT_DOMAIN]'); ?>
				</button>
			</p>

			<?php do_action('woocommerce_login_form_end'); ?>
		</form>

		<div class="selleradise_account-form__option">
			<?php echo esc_html(__('Lost your password?', '[TEXT_DOMAIN]')); ?>

			<a href="<?php echo esc_url(wp_lostpassword_url()); ?>">
				<?php echo esc_html(__('Reset here', '[TEXT_DOMAIN]')); ?>
			</a>
		</div>

		<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>
			<div class="selleradise_account-form__option">

				<?php echo esc_html(__("Don't have an account?", '[TEXT_DOMAIN]')); ?>

				<button x-on:click.prevent="active = 'register'">
					<?php echo esc_html(__('Register here', '[TEXT_DOMAIN]')); ?>
				</button>
			</div>
		<?php endif; ?>
	</div>


	<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

		<div
		  x-show="active === 'register'"
		  class="selleradise_account-form selleradise_account-form--register"
		  x-transition:enter="xyz-in"
			xyz="fade down-5 duration-3"
		 >
			<h2 class="selleradise_account-form__title">
				<?php echo esc_html(__('Register', '[TEXT_DOMAIN]')); ?>
			</h2>

			<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?>>
				<?php do_action('woocommerce_register_form_start'); ?>

				<?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="reg_username"><?php esc_html_e('Username', '[TEXT_DOMAIN]'); ?>&nbsp;<span class="required">*</span></label>
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
																																																																																																																														?>
					</p>

				<?php endif; ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_email"><?php esc_html_e('Email address', '[TEXT_DOMAIN]'); ?>&nbsp;<span class="required">*</span></label>
					<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
																																																																																																																						?>
				</p>

				<?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="reg_password"><?php esc_html_e('Password', '[TEXT_DOMAIN]'); ?>&nbsp;<span class="required">*</span></label>
						<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
					</p>

				<?php else : ?>

					<p><?php esc_html_e('A password will be sent to your email address.', '[TEXT_DOMAIN]'); ?></p>

				<?php endif; ?>

				<?php do_action('woocommerce_register_form'); ?>

				<p class="woocommerce-form-row form-row">
					<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
					<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', '[TEXT_DOMAIN]'); ?>"><?php esc_html_e('Register', '[TEXT_DOMAIN]'); ?></button>
				</p>

				<?php do_action('woocommerce_register_form_end'); ?>

			</form>

			<div class="selleradise_account-form__option">
				<?php echo esc_html(__("Already have an account?", '[TEXT_DOMAIN]')); ?>

				<button x-on:click.prevent="active = 'login'">
					<?php echo esc_html(__('Login here', '[TEXT_DOMAIN]')); ?>
				</button>
			</div>
		</div>



	<?php endif; ?>
</div>


<?php do_action('woocommerce_after_customer_login_form'); ?>