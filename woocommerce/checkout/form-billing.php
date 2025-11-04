<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;

$current_user = wp_get_current_user();
$user_email='';
if (is_user_logged_in()) {
    $user_email = $current_user->user_email;
}
?>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->

<!-- Contact information -->
<fieldset
        class="wc-block-checkout__contact-fields wp-block-woocommerce-checkout-contact-information-block wc-block-components-checkout-step wc-block-components-checkout-step--with-step-number"
        id="contact-fields">

    <legend class="screen-reader-text">Contact information
    </legend>
    <div class="wc-block-components-checkout-step__heading">
        <h2 class="wc-block-components-title wc-block-components-checkout-step__title"
            aria-hidden="true">Contact information</h2><span
                class="wc-block-components-checkout-step__heading-content"></span>
    </div>
    <div class="wc-block-components-checkout-step__container">
        <div class="wc-block-components-checkout-step__content">
            <div class="wc-block-components-notices"></div>
            <div class="wc-block-components-notices__snackbar wc-block-components-notice-snackbar-list"
                 tabindex="-1">
                <div></div>
            </div>
            <div id="contact"
                 class="wc-block-components-address-form">
                <label for="email">Email<span
                            class="red__star">*</span></label>
                <div
                        class="wc-block-components-text-input wc-block-components-address-form__email form__input form__input-full-width">
                    <input type="text"
                           name="billing_email"
                           id="billing_email"
                           autocapitalize="none"
                           autocomplete="email"
                           aria-label="Email address" required=""
                           aria-invalid="false"
                           title=""
                           value="<?php echo $user_email;?>"
                           placeholder="Your Email Address">
                </div>
                <div class="custom-checkbox">
                    <input type="checkbox" name="checkBox"
                           id="checkBox">
                    <label for="checkBox">Email me with news and
                        offers</label>
                </div>
            </div>
        </div>
    </div>

</fieldset>

<!-- /Contact information -->

<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

<div class="woocommerce-billing-fields__field-wrapper">
    <?php
    $fields = $checkout->get_checkout_fields( 'billing' );

    foreach ( $fields as $key => $field ) {
        woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
    }
    ?>
</div>

<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>


<!-- empty fields -->
<div data-block-name="woocommerce/checkout-shipping-method-block"
     class="wp-block-woocommerce-checkout-shipping-method-block">
</div>

<div data-block-name="woocommerce/checkout-pickup-options-block"
     class="wp-block-woocommerce-checkout-pickup-options-block">
</div>
<!-- /empty fields -->



<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->
<?php return ;?>



<div class="woocommerce-billing-fields">
	<?php if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ) : ?>

		<h3><?php esc_html_e( 'Billing &amp; Shipping', 'woocommerce' ); ?></h3>

	<?php else : ?>

		<h3><?php esc_html_e( 'Billing details', 'woocommerce' ); ?></h3>

	<?php endif; ?>

	<?php do_action( 'woocommerce_before_checkout_billing_form', $checkout ); ?>

	<div class="woocommerce-billing-fields__field-wrapper">
		<?php
		$fields = $checkout->get_checkout_fields( 'billing' );

		foreach ( $fields as $key => $field ) {
			woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
		}
		?>
	</div>

	<?php do_action( 'woocommerce_after_checkout_billing_form', $checkout ); ?>
</div>

<?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
	<div class="woocommerce-account-fields">
		<?php if ( ! $checkout->is_registration_required() ) : ?>

			<p class="form-row form-row-wide create-account">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="createaccount" <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?> type="checkbox" name="createaccount" value="1" /> <span><?php esc_html_e( 'Create an account?', 'woocommerce' ); ?></span>
				</label>
			</p>

		<?php endif; ?>

		<?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>

		<?php if ( $checkout->get_checkout_fields( 'account' ) ) : ?>

			<div class="create-account">
				<?php foreach ( $checkout->get_checkout_fields( 'account' ) as $key => $field ) : ?>
					<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
	</div>
<?php endif; ?>

<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->