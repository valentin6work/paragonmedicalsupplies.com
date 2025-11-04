<?php
/**
 * Checkout shipping information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-shipping.php.
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
?>

<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->

<!-- Shipping Details -->
<fieldset
        class="woocommerce-shipping-fields wp-block-woocommerce-checkout-shipping-address-block wc-block-components-checkout-step"
        id="shipping-fields">
    <legend class="screen-reader-text">Shipping Details</legend>
    <div class="wc-block-components-checkout-step__heading">
        <h2 class="wc-block-components-title wc-block-components-checkout-step__title"
            aria-hidden="true">Shipping Details</h2>
    </div>
    <div class="wc-block-components-checkout-step__container">
        <div class="wc-block-components-checkout-step__content">

            <div class="wc-block-components-notices"></div>

            <div class="wc-block-components-notices__snackbar wc-block-components-notice-snackbar-list"
                 tabindex="-1">
                <div></div>
            </div>

            <div class="shipping_address">
                <div
                        class="woocommerce-shipping-fields__field-wrapper form-input">

                    <!--
                    <label for="shipping-first_name">First
                        name<span class="red__star">*</span>
                        <div
                                class="wc-block-components-text-input wc-block-components-address-form__first_name form__input">
                            <input type="text"
                                   id="shipping-first_name"
                                   autocapitalize="sentences"
                                   autocomplete="given-name"
                                   aria-label="First name"
                                   required="" aria-invalid="false"
                                   title="" value=""
                                   placeholder="First name">
                        </div>
                    </label>
                    <label for="shipping-last_name">Last
                        name<span class="red__star">*</span>
                        <div
                                class="wc-block-components-text-input wc-block-components-address-form__last_name form__input">
                            <input type="text"
                                   id="shipping-last_name"
                                   autocapitalize="sentences"
                                   autocomplete="family-name"
                                   aria-label="Last name"
                                   required="" aria-invalid="false"
                                   title="" value=""
                                   placeholder="Last name">
                        </div>
                    </label>
                    <label class="full-width"
                           for="shipping-phone">Phone Number<span
                                class="red__star">*</span>
                        <div
                                class="wc-block-components-text-input wc-block-components-address-form__phone form__input">
                            <input type="tel"
                                   id="shipping-phone"
                                   autocapitalize="characters"
                                   autocomplete="tel"
                                   aria-invalid="false" title=""
                                   value=""
                                   placeholder="Phone Number"
                                   required>
                        </div>
                    </label>
                    <label for="shipping-address_1">Street
                        Address <span class="red__star">*</span>
                        <div
                                class="wc-block-components-text-input wc-block-components-address-form__address_1">
                            <input type="text"
                                   id="shipping-address_1"
                                   autocapitalize="sentences"
                                   autocomplete="address-line1"
                                   aria-label="Street address"
                                   required="" aria-invalid="false"
                                   title="" value=""
                                   placeholder="Street Address">
                        </div>
                    </label>
                    <label for="shipping-address_2">Address
                        Details
                        <div
                                class="wc-block-components-text-input wc-block-components-address-form__address_2 form__input">
                            <input type="text"
                                   id="shipping-address_2"
                                   autocapitalize="sentences"
                                   autocomplete="address-line2"
                                   aria-label="Apartment, suite, unit, etc."
                                   aria-invalid="false" title=""
                                   value=""
                                   placeholder="Apt, suite, unit, floor">
                        </div></label>
                    <label for="shipping-city"
                           class="full-width">City<span
                                class="red__star">*</span>
                        <div
                                class="wc-block-components-text-input wc-block-components-address-form__city form__input">
                            <select id="shipping-city"
                                    class="js-example-basic-single"
                                    required>
                                <option value=""
                                        selected>Select city
                                </option>
                                <option value="city1">City 1
                                </option>
                                <option value="city2">City 2
                                </option>
                                <option value="city3">City 3
                                </option>
                            </select>
                        </div>
                    </label>
                    <label for="shipping-postcode">ZIP Code<span
                                class="red__star">*</span>
                        <div
                                class="wc-block-components-text-input wc-block-components-address-form__postcode form__input">
                            <input type="text"
                                   id="shipping-postcode"
                                   autocapitalize="characters"
                                   autocomplete="postal-code"
                                   aria-label="Postcode / ZIP"
                                   required="" aria-invalid="false"
                                   title="" value=""
                                   placeholder="ZIP Code">
                        </div>
                    </label>
                    <label for="shipping-state">State<span
                                class="red__star">*</span>
                        <div id="shipping-state"
                             class="wc-block-components-combobox wc-block-components-address-form__state wc-block-components-state-input form__input">
                            <select id="stateSelect"
                                    class="js-example-basic-single"
                                    required>
                                <option value=""
                                        selected>Select state
                                </option>
                                <option value="State1">State 1
                                </option>
                                <option value="State2">State 2
                                </option>
                                <option value="State3">State 3
                                </option>
                            </select>
                        </div>
                    </label>
                    <label for="shipping-method"
                           class="full-width">Shipping Method<span
                                class="red__star">*</span>
                        <div id="shipping-method"
                             class="wc-block-components-combobox wc-block-components-address-form__state wc-block-components-state-input form__input">
                            <select id="shipping-method"
                                    class="js-example-basic-single"
                                    required>
                                <option value=""
                                        selected>Select shipping
                                    method</option>
                                <option value="shMethod1">
                                    shipping method 1</option>
                                <option value="shMethod2">
                                    shipping method 2</option>
                                <option value="shMethod3">
                                    shipping method 3</option>
                            </select>
                        </div>
                    </label>
                    -->

                    <?php
                        $checkout = WC()->checkout();
                        $shipping_fields = $checkout->get_checkout_fields('shipping');

                        if (!empty($shipping_fields)) {
                            foreach ($shipping_fields as $key => $field) {
                                $required = !empty($field['required']) ? '<span class="red__star">*</span>' : '';
                                $label = !empty($field['label']) ? esc_html($field['label']) : '';
                                $placeholder = !empty($field['placeholder']) ? esc_attr($field['placeholder']) : '';

                                if ($field['type'] === 'select' && !empty($field['options'])) {
                                    echo '<label for="' . esc_attr($key) . '" class="full-width">' . $label . $required;
                                    echo '<div class="wc-block-components-text-input wc-block-components-address-form__' . esc_attr($key) . ' form__input">';
                                    echo '<select id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" class="js-example-basic-single" required>';
                                    foreach ($field['options'] as $option_key => $option_label) {
                                        echo '<option value="' . esc_attr($option_key) . '" ' . selected($checkout->get_value($key), $option_key, false) . '>' . esc_html($option_label) . '</option>';
                                    }
                                    echo '</select>';
                                    echo '</div></label>';
                                } else {

                                    $s_class='';

                                    switch ($key)
                                    {
                                        case 'shipping_phone':
                                            $s_class='class="full-width"';
                                            break;
                                    }

                                    echo '<label '.$s_class.' for="' . esc_attr($key) . '">' . $label . $required;

                                    echo '<div class="wc-block-components-text-input wc-block-components-address-form__' . esc_attr($key) . ' form__input">';
                                    echo '<input type="text" 
                            id="' . esc_attr($key) . '" 
                            name="' . esc_attr($key) . '" 
                            value="' . esc_attr($checkout->get_value($key)) . '" 
                            placeholder="' . $placeholder . '" 
                            ' . ($field['required'] ? 'required="true"' : '') . '
                            ' . ($field['required'] ? 'aria-required="true" ' : '') . '
                            
                            autocomplete="given-name"
                            autocomplete="' . (!empty($field['autocomplete']) ? esc_attr($field['autocomplete']) : 'off') . '" />';
                                    echo '</div></label>';
                                }
                            }
                        }
                    ?>


                </div>
            </div>
        </div>
    </div>
</fieldset>
<!-- /Shipping Details -->

<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ]  -->

<?php return;?>

<div class="woocommerce-shipping-fields">
	<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>

		<h3 id="ship-to-different-address">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span><?php esc_html_e( 'Ship to a different address?', 'woocommerce' ); ?></span>
			</label>
		</h3>

		<div class="shipping_address">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<div class="woocommerce-shipping-fields__field-wrapper">
				<?php
				$fields = $checkout->get_checkout_fields( 'shipping' );

				foreach ( $fields as $key => $field ) {
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				}
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	<?php endif; ?>
</div>
<div class="woocommerce-additional-fields">
	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>

			<h3><?php esc_html_e( 'Additional information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<div class="woocommerce-additional-fields__field-wrapper">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ]  -->