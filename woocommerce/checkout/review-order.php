<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>


<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->

<div class="wc-block-components-sidebar wc-block-checkout__sidebar wp-block-woocommerce-checkout-totals-block">
    <div class="wc-block-components-notices"></div>
    <div class="wc-block-components-notices__snackbar wc-block-components-notice-snackbar-list" tabindex="-1">
        <div></div>
    </div>
    <h3><?php esc_html_e('Your Order', 'woocommerce'); ?></h3>
    <div class="wp-block-woocommerce-checkout-order-summary-block">
        <div class="wp-block-woocommerce-checkout-order-summary-cart-items-block wc-block-components-totals-wrapper">
            <div class="wc-block-components-order-summary wc-block-components-panel">
                <div class="wc-block-components-panel__content">
                    <div class="wc-block-components-order-summary__content scroll-block__styles">
                        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                            $product = $cart_item['data'];
                            $product_image = $product->get_image();
                            $product_name = $product->get_name();
                            $product_sku = $product->get_sku();
                            $product_price = wc_price($product->get_price());
                            $product_quantity = $cart_item['quantity'];
                            $total_price = wc_price($cart_item['line_total']);
                            ?>
                            <div class="wc-block-components-order-summary-item">
                                <div class="wc-block-components-order-summary-item__image">
                                    <?php echo $product_image; ?>
                                </div>
                                <div class="wc-block-components-order-summary-item__description">
                                    <span class="wc-block-components-product-name"><?php echo $product_name; ?></span>
                                    <div class="wc-block-components-product-metadata">
                                        <div class="wc-block-components-product-metadata__description">
                                            <p><?php esc_html_e('SKU:', 'woocommerce'); ?> <?php echo $product_sku; ?></p>
                                        </div>
                                    </div>
                                    <div class="order__price-block">
                                        <div class="wc-block-components-product-price__value wc-block-components-order-summary-item__individual-price">
                                            <?php echo $product_price; ?>
                                        </div>
                                        <div class="wc-block-components-order-summary-item__quantity">
                                            <span aria-hidden="true">x<?php echo $product_quantity; ?></span>
                                        </div>
                                        <div class="wc-block-components-order-summary-item__total-price">
                                            <?php echo $total_price; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subtotal -->
        <div class="wp-block-woocommerce-checkout-order-summary-subtotal-block wc-block-components-totals-wrapper">
            <div class="wc-block-components-totals-item">
                <span class="wc-block-components-totals-item__label"><?php esc_html_e('Subtotal', 'woocommerce'); ?></span>
                <span class="wc-block-components-totals-item__value"><?php echo wc_price(WC()->cart->get_subtotal()); ?></span>
            </div>
        </div>



        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <!-- coupon -->
            <div class="wp-block-woocommerce-checkout-order-summary-tax-block wc-block-components-totals-wrapper cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>" >
                <div class="wc-block-components-totals-item">
                    <span class="wc-block-components-totals-item__label"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
                    <span class="wc-block-components-totals-item__value"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
                </div>
            </div>
            <!-- /coupon -->
        <?php endforeach; ?>

        <!-- Tax -->
        <div class="wp-block-woocommerce-checkout-order-summary-tax-block wc-block-components-totals-wrapper">
            <div class="wc-block-components-totals-item">
                <span class="wc-block-components-totals-item__label"><?php esc_html_e('Tax', 'woocommerce'); ?></span>
                <span class="wc-block-components-totals-item__value"><?php echo wc_price(WC()->cart->get_taxes_total()); ?></span>
            </div>
        </div>

        <!-- Shipping -->
        <div class="wp-block-woocommerce-checkout-order-summary-shipping-block wc-block-components-totals-wrapper">
            <div class="wc-block-components-totals-item">
                <span class="wc-block-components-totals-item__label"><?php esc_html_e('Shipping', 'woocommerce'); ?></span>
                <span class="wc-block-components-totals-item__value"><?php echo wc_price(WC()->cart->get_shipping_total()); ?></span>
            </div>
        </div>

        <!-- Total -->
        <div class="wc-block-components-totals-wrapper">
            <div class="wc-block-components-totals-item wc-block-components-totals-footer-item">
                <span class="wc-block-components-totals-item__label"><?php esc_html_e('Total', 'woocommerce'); ?></span>
                <div class="wc-block-components-totals-item__value">
                    <span><?php wc_cart_totals_order_total_html(); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!--
<table class="shop_table woocommerce-checkout-review-order-table">
	<thead>
		<tr>
			<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<td class="product-name">
						<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
						<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
					<td class="product-total">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot>

		<tr class="cart-subtotal">
			<th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">
			<th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>

-->
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->
