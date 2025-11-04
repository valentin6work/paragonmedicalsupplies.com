<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->


<div id="payment" class="woocommerce-checkout-payment wc-block-components-checkout-step__container">
    <div class="wc-block-components-checkout-step__content">
        <div class="wc-block-components-notices"></div>
        <div class="wc-block-components-notices__snackbar wc-block-components-notice-snackbar-list" tabindex="-1">
            <div></div>
        </div>
        <div class="wc-block-components-radio-control">
            <?php if ( ! empty( $available_gateways ) ) : ?>
                <?php foreach ( $available_gateways as $gateway ) : ?>
                    <div class="wc-block-components-radio-control-accordion-option">
                        <label class="wc-block-components-radio-control__option <?php echo $gateway->chosen ? 'wc-block-components-radio-control__option-checked' : ''; ?>" for="radio-control-wc-payment-method-options-<?php echo esc_attr( $gateway->id ); ?>">
                            <input id="radio-control-wc-payment-method-options-<?php echo esc_attr( $gateway->id ); ?>"
                                   class="wc-block-components-radio-control__input"
                                   type="radio"
                                   name="payment_method"
                                   value="<?php echo esc_attr( $gateway->id ); ?>"
                                <?php checked( $gateway->chosen, true ); ?>>
                            <div class="wc-block-components-radio-control__option-layout">
                                <div class="wc-block-components-radio-control__icon">
                                    <?php if ( $icon = $gateway->get_icon() ) : ?>
                                        <?php echo $icon; ?>
                                    <?php else : ?>
                                        <img src="<?php echo theme_url;?>/img/card.svg" alt="icon">
                                    <?php endif; ?>
                                </div>
                                <div class="wc-block-components-radio-control__label-group">
                                <span id="radio-control-wc-payment-method-options-<?php echo esc_attr( $gateway->id ); ?>__label" class="wc-block-components-radio-control__label">
                                    <span class="wc-block-components-payment-method-label"><?php echo esc_html( $gateway->get_title() ); ?></span>
                                </span>
                                </div>
                            </div>
                        </label>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p><?php esc_html_e( 'No available payment methods.', 'woocommerce' ); ?></p>
            <?php endif; ?>
        </div>


        <div class="select__payments-block form__input-style">

        </div>

    </div>
</div>




<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ]  -->
<?php
if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
