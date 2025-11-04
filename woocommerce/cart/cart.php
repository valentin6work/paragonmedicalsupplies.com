<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );


$shop_page_id = get_option('woocommerce_shop_page_id');
$shop_url = get_permalink($shop_page_id);

?>

<div data-block-name="woocommerce/cart" class="wp-block-woocommerce-cart alignwide">
    <div class="with-scroll-to-top__scroll-point" aria-hidden="true"></div>
    <div class="wc-block-components-notices"></div>
    <div class="wc-block-components-notices__snackbar wc-block-components-notice-snackbar-list" tabindex="-1">
        <div></div>
    </div>
    <div>
        <div aria-hidden="false">
            <div class="wc-block-components-sidebar-layout wc-block-cart wp-block-woocommerce-filled-cart-block is-large">
                <div aria-hidden="true" style="position: absolute; inset: 0px; pointer-events: none; opacity: 0; overflow: hidden; z-index: -1;"></div>
                <div class="wc-block-components-main wc-block-cart__main wp-block-woocommerce-cart-items-block scroll-block__styles">
                    <table class="wc-block-cart-items wp-block-woocommerce-cart-line-items-block" tabindex="-1">
                        <thead>
                        <tr class="wc-block-cart-items__header">
                            <th class="wc-block-cart-items__header-image"><span>Image</span></th>
                            <th class="wc-block-cart-items__header-product"><span>DESCRIPTION</span></th>
                            <th class="wc-block-cart-items__header-prices"><span>PRICE</span></th>
                            <th class="wc-block-cart-items__header-quantity"><span>QTY.</span></th>
                            <th class="wc-block-cart-items__header-total"><span>Total</span></th>
                            <th class="wc-block-cart-items__header-remove"><span>Remove</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                            $_product = $cart_item['data'];
                            $product_price = WC()->cart->get_product_price($_product);
                            $product_total = $cart_item['line_total'];
                            ?>
                            <tr class="wc-block-cart-items__row" tabindex="-1" data-cart_item_key="<?php echo $cart_item_key; ?>">
                                <td class="wc-block-cart-item__image" aria-hidden="true">
                                    <a href="<?php echo esc_url(get_permalink($_product->get_id())); ?>" tabindex="-1">
                                        <?php echo $_product->get_image(); ?>
                                    </a>
                                </td>
                                <td class="wc-block-cart-item__product">
                                    <div class="wc-block-cart-item__wrap">
                                        <a class="wc-block-components-product-name" href="<?php echo esc_url(get_permalink($_product->get_id())); ?>">
                                            <?php echo $_product->get_name(); ?>
                                        </a>
                                        <div class="wc-block-components-product-metadata">
                                            <div class="wc-block-components-product-metadata__description">
                                                <p>SKU: <?php echo $_product->get_sku(); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="wc-block-cart-item__prices">
                                    <div>
                                            <span class="price wc-block-components-product-price">
                                                <bdi><?php echo $product_price; ?></bdi>
                                            </span>
                                    </div>
                                </td>
                                <td class="wc-block-cart-item__quantity">
                                    <div class="wc-block-components-quantity-selector">
                                        <input class="wc-block-components-quantity-selector__input" type="number" step="1" min="1" max="9999" value="<?php echo $cart_item['quantity']; ?>">
                                        <div class="btn-quant-prod__wrap">
                                            <button class="wc-block-components-quantity-selector__button wc-block-components-quantity-selector__button--plus plus_change">
                                                <img src="<?php echo theme_url;?>/img/down-arrow.svg" alt="arrow">
                                            </button>
                                            <button class="wc-block-components-quantity-selector__button wc-block-components-quantity-selector__button--minus minus_change"><img src="<?php echo theme_url;?>/img/down-arrow.svg" alt="arrow"></button>
                                        </div>
                                    </div>
                                </td>
                                <td class="wc-block-cart-item__total">
                                    <div class="wc-block-cart-item__total-price-and-sale-badge-wrapper">
                                            <span class="price wc-block-components-product-price">
                                                <span class="wc-block-formatted-money-amount wc-block-components-formatted-money-amount wc-block-components-product-price__value">
                                                    <bdi><?php echo wc_price($product_total); ?></bdi>
                                                </span>
                                            </span>
                                    </div>
                                </td>
                                <td class="wc-block-cart-item__remove">
                                    <a href="<?php echo esc_url( wc_get_cart_remove_url($cart_item_key) ); ?>" class="wc-block-cart-item__remove-link" aria-label="Remove from cart">
                                        <button class="wc-block-cart-item__remove-link"
                                                aria-label="Remove from cart">
                                        <img
                                                src="<?php echo theme_url;?>/img/close_filter_cell.svg"
                                                alt="icon">
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="wc-block-components-sidebar wc-block-cart__sidebar wp-block-woocommerce-cart-totals-block">
                    <div class="wp-block-woocommerce-cart-order-summary-block">
                        <div class="wp-block-woocommerce-cart-order-summary-subtotal-block wc-block-components-totals-wrapper">
                            <div class="wc-block-components-totals-item">
                                <span class="wc-block-components-totals-item__label">Subtotal</span>
                                <span class="wc-block-formatted-money-amount wc-block-components-formatted-money-amount wc-block-components-totals-item__value">
                                    <?php echo wc_price(WC()->cart->subtotal); ?>
                                </span>
                            </div>
                        </div>

                        <div class="wp-block-woocommerce-cart-order-summary-tax-block wc-block-components-totals-wrapper">
                            <div class="wc-block-components-totals-item">
                                <span class="wc-block-components-totals-item__label">Tax</span>
                                <span class="wc-block-formatted-money-amount wc-block-components-formatted-money-amount"><?php echo wc_price(WC()->cart->get_taxes_total()); ?></span>
                            </div>
                        </div>

                        <?php display_quantity_discount_cart();?>

                        <div class="wp-block-woocommerce-cart-order-summary-shipping-block wc-block-components-totals-wrapper">
                            <div class="wc-block-components-totals-item">
                                <span class="wc-block-components-totals-item__label">Shipping</span>
                                <span class="wc-block-formatted-money-amount wc-block-components-formatted-money-amount"><?php echo wc_price(WC()->cart->get_shipping_total()); ?></span>
                            </div>
                        </div>

                        <div class="wc-block-components-totals-wrapper">
                            <div class="wc-block-components-totals-item wc-block-components-totals-footer-item">
                                <span class="wc-block-components-totals-item__label">Total</span>
                                <div class="wc-block-components-totals-item__value">
                                    <span class="wc-block-formatted-money-amount wc-block-components-formatted-money-amount wc-block-components-totals-footer-item-tax-value">
                                        <?php echo wc_price(WC()->cart->total); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wc-block-cart__submit wp-block-woocommerce-proceed-to-checkout-block">
                        <div class="cart-btn-back__wrap">
                            <a href="<?php echo $shop_url;?>" class="btn-main">back to shopping</a>
                        </div>
                        <div class="wc-block-cart__submit-container white-bg">
                            <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="btn-main components-button wc-block-components-button wp-element-button wc-block-cart__submit-button contained">
                                <span class="wc-block-components-button__text">Proceed to Checkout</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;"></div>
</div>
<div class="post-tags">
</div>

<?php
    return;
?>
<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-remove"><span class="screen-reader-text"><?php esc_html_e( 'Remove item', 'woocommerce' ); ?></span></th>
				<th class="product-thumbnail"><span class="screen-reader-text"><?php esc_html_e( 'Thumbnail image', 'woocommerce' ); ?></span></th>
				<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="product-subtotal"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				/**
				 * Filter the product name.
				 *
				 * @since 2.1.0
				 * @param string $product_name Name of the product in the cart.
				 * @param array $cart_item The product in the cart.
				 * @param string $cart_item_key Key for the product in the cart.
				 */
				$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<td class="product-remove">
							<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										/* translators: %s is the product name */
										esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
							?>
						</td>

						<td class="product-thumbnail">
						<?php
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo $thumbnail; // PHPCS: XSS ok.
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
						}
						?>
						</td>

						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
						<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( $product_name . '&nbsp;' );
						} else {
							/**
							 * This filter is documented above.
							 *
							 * @since 2.1.0
							 */
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						}

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
						}
						?>
						</td>

						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>

						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
						<?php
						if ( $_product->is_sold_individually() ) {
							$min_quantity = 1;
							$max_quantity = 1;
						} else {
							$min_quantity = 0;
							$max_quantity = $_product->get_max_purchase_quantity();
						}

						$product_quantity = woocommerce_quantity_input(
							array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $max_quantity,
								'min_value'    => $min_quantity,
								'product_name' => $product_name,
							),
							$_product,
							false
						);

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</td>
					</tr>
					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr>
				<td colspan="6" class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="coupon">
							<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</div>
					<?php } ?>

					<button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
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
