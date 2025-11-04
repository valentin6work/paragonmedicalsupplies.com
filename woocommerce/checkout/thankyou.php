<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;


?>

<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->

<article class="order-received__content">
    <header class="entry-header">
        <h1 class="entry-title">Your order is on the way!</h1>
    </header>
    <div class="entry-content">
        <div class="woocommerce">
            <div class="woocommerce-order white-bg">
                <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
                    We received your order today <?php echo date_format( $order->get_date_created(), 'm/d/y' ); ?>  and it should arrive in 2-5 business days.</p>
                <img src="<?php echo theme_url;?>/img/order-rec-icon.svg" alt="icon">
                <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
                    <li class="woocommerce-order-overview__order order">
                        Order number: <span><?php echo $order->get_order_number();?></span>
                    </li>
                </ul>
                <a href="#" class="btn-main btn-large">track your order</a>
                <div class="woocommerce-order-details">
                    <h2 class="woocommerce-order-details__title">Order Summary</h2>
                    <table
                            class="woocommerce-table woocommerce-table--order-details shop_table order_details">

                        <thead>
                        <tr>
                            <th class="woocommerce-table__product-name product-name">Product</th>
                            <th class="woocommerce-table__product-table product-quantity">Quantity</th>
                            <th class="woocommerce-table__product-table product-total">Total</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                            $items = $order->get_items();
                            foreach ($items as $item) {
                                $product_name = $item->get_name();
                                $product_qty = $item->get_quantity();
                                $product_price = wc_price($item->get_total());
                                $link = $item->get_product()->get_permalink();

                                echo "
                                    <tr class=\"woocommerce-table__line-item order_item\">
                                        <td class=\"woocommerce-table__product-name product-name\">
                                            <a href=\"$link\">$product_name</a>
                                        </td>
                                        <td class=\"woocommerce-table__product-quantity product-quantity\">
                                            Qty: <span>$product_qty</span></td>
                                        <td class=\"woocommerce-table__product-total product-total\">
                                             $product_price
                                        </td>
                                    </tr>
                                ";
                            }
                        ?>

                        </tbody>
                        <tfoot>
                        <tr>
                            <th scope="row">Subtotal:</th>
                            <td colspan="2">
                                <?php echo wc_price($order->get_subtotal()); ?>
                            </td>
                        </tr>

                        <?php
                            $discount_percentage = $order->get_meta('Quantity Discount Percentage');
                            $discount_total = $order->get_meta('Quantity Discount Total');
                            //echo $discount_percentage;

                            if ($discount_percentage && $discount_total){
                        ?>
                                <tr>
                                    <th scope="row">You Quantity Discount</th>
                                    <td colspan="2"><?php echo wc_price($discount_total); ?>
                                    </td>
                                </tr>
                        <?php } ?>
                        <tr>
                            <th scope="row">Tax</th>
                            <td colspan="2"><?php echo wc_price($order->get_total_tax()); ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Shipping</th>
                            <td colspan="2">
                                <?php echo wc_price($order->get_shipping_total()); ?>
                            </td>
                        </tr>

                        <!-- payment -->
                        <?php if ( $order->get_payment_method_title() ) : ?>
                            <tr>
                                <th scope="row">
                                    <?php esc_html_e( 'Payment method:', 'woocommerce' ); ?></th>
                                <td colspan="2">
                                    <?php echo wp_kses_post( $order->get_payment_method_title() ); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <!-- /payment -->

                        <!-- total -->
                        <tr>
                            <th scope="row" class="order-rec__total">Total:</th>
                            <td colspan="2">
                                <?php echo $order->get_formatted_order_total(); ?>
                            </td>
                        </tr>
                        <!-- /total -->

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</article>

<?php return ;?>

<div class="woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>

<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->