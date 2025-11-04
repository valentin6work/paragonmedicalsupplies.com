<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->

<div class="wc-block-components-main wc-block-checkout__main wp-block-woocommerce-checkout-fields-block">
    <header class="entry-header">
        <h1 class="entry-title">Checkout</h1>
    </header>

        <form name="checkout" method="post" class="checkout woocommerce-checkout wc-block-components-form wc-block-checkout__form form__input-style" id="wc_form_checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
            <!-- start wriper -->
            <div class="form_sp_wrape" >

                <?php if ( $checkout->get_checkout_fields() ) : ?>

                <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

                        <?php do_action( 'woocommerce_checkout_billing' ); ?>

                        <?php do_action( 'woocommerce_checkout_shipping' ); ?>

                <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

            <?php endif; ?>

                <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

               <!-- <h3 id="order_review_heading"><?php /*esc_html_e( 'Your order', 'woocommerce' ); */?></h3>-->

                <?php
                    $packages = WC()->shipping()->get_packages();
                    $shipping_methods = WC()->shipping()->get_shipping_methods();
                ?>

                <!-- Shipping Methods -->
                <label for="shipping-method" class="full-width">
                    Shipping Method<span class="red__star">*</span>
                    <div id="shipping-method" class="wc-block-components-combobox wc-block-components-address-form__state wc-block-components-state-input form__input">
                        <select name="shipping_method" id="shipping_method" class="js-example-basic-single shipping-method-select" required>
                            <option value="" selected>Select shipping method</option>
                            <?php
                            $chosen_shipping_method = WC()->session->get('chosen_shipping_methods')[0] ?? '';
                                foreach ($packages as $i => $package) {
                                    foreach ($package['rates'] as $rate_id => $rate) {
                                        $selected = ($chosen_shipping_method === $rate_id) ? 'selected' : '';

                                        echo '<option '.$selected.' value="' . esc_attr($rate_id) . '">'.$rate->get_label() . ' - ' .$rate->get_cost() . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </label>
                <!-- /Shipping Methods -->



            </div>
            <!-- /end wriper -->

            <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                </div>
            <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

            <!-- payment method -->
            <fieldset class="wc-block-checkout__payment-method  wp-block-woocommerce-checkout-payment-block wc-block-components-checkout-step wc-block-components-checkout-step--with-step-number" id="payment-method">
                <legend class="screen-reader-text">Payment Method</legend>
                <div class="wc-block-components-checkout-step__heading">
                    <h2 class="wc-block-components-title wc-block-components-checkout-step__title" aria-hidden="true">Payment Method</h2>
                </div>

                <?php wc_get_template( 'checkout/payment.php' ); ?>

            </fieldset>
            <!-- /payment method -->

            <div class="wc-block-checkout__actions wp-block-woocommerce-checkout-actions-block">
                <div class="wc-block-components-notices"></div>
                <div class="wc-block-components-notices__snackbar wc-block-components-notice-snackbar-list"
                     tabindex="-1">
                    <div></div>
                </div>
                <div class="wc-block-checkout__actions_row">
                    <a href="<?php echo wc_get_cart_url();?>" class="btn-main btn-large btn-border wc-block-components-checkout-return-to-cart-button">back to Cart</a>
                    <div class="white-bg">

                        <?php do_action( 'woocommerce_review_order_before_submit' ); ?>

                       <!-- <button type="submit" class="button alt wp-element-button" name="woocommerce_checkout_place_order" id="place_order" value="Place order" data-value="Place order">Place order</button>
-->
                        <button type="submit"
                                class="btn-main btn-large btn-border components-button wc-block-components-button wp-element-button wc-block-components-checkout-place-order-button contained" name="woocommerce_checkout_place_order" id="place_order"  >Confirm Order</button>

                        <?php do_action( 'woocommerce_review_order_after_submit' ); ?>

                        <?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>

                    </div>
                </div>
            </div>
        </form>

</div>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ]  -->
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
