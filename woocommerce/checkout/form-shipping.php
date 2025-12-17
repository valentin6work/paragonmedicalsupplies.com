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

                    <?php if (is_user_logged_in()) { ?>
                        <label for="shippingAddressName"
                               class="full-width">Address Name
                            <div class="form__input">

                                <?php
                                $user_id = get_current_user_id();
                                $shipping_field_saved = get_user_meta($user_id, 'shipping_field_saved', true);

                                $default_index = '';
                                if (is_array($shipping_field_saved)) {
                                    foreach ($shipping_field_saved as $i => $addr) {
                                        if (!empty($addr['is_default'])) {
                                            $default_index = (string) $i;
                                            break;
                                        }
                                    }
                                }
                                ?>

                                <select id="shippingAddressName"
                                        class="js-example-basic-single"
                                        required >

                                    <option value="">Select address name</option>

                                    <?php if (is_array($shipping_field_saved)) :
                                        foreach ($shipping_field_saved as $idx => $addr) : ?>
                                            <option
                                                    value="<?php echo esc_attr($idx); ?>"
                                                <?php selected((string)$idx, $default_index); ?>
                                                    data-address='<?php echo esc_attr(wp_json_encode($addr)); ?>'>
                                                <?php echo esc_html($addr['address_name']); ?>
                                            </option>
                                        <?php endforeach;
                                    endif; ?>

                                </select>


                            </div>
                        </label>
                    <?php } ?>


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

<?php if (is_user_logged_in()) { ?>
    <script>
        (function ($) {

            function getAddressFromShippingSelect() {
                const $select = $('#shippingAddressName');

                if (!$select.length) return null;

                // Select2
                if ($select.hasClass('select2-hidden-accessible')) {
                    const data = $select.select2('data');
                    if (!data || !data.length) return null;

                    const raw = data[0].element?.dataset?.address;
                    if (!raw) return null;

                    try {
                        return JSON.parse(raw);
                    } catch (e) {
                        console.error('Invalid JSON in data-address:', raw);
                        return null;
                    }
                }

                // fallback
                const raw = $select.find('option:selected').attr('data-address');
                if (!raw) return null;

                try {
                    return JSON.parse(raw);
                } catch (e) {
                    console.error('Invalid JSON in data-address:', raw);
                    return null;
                }
            }

            function setSelectValue($select, value) {
                if (!$select.length) return;
                if (!value) return;

                $select.val(value).trigger('change');
                $select.trigger('change.select2');
            }

            function waitAndSetState(state) {
                const $state = $('#shipping_state');
                let attempts = 0;

                const timer = setInterval(() => {
                    attempts++;

                    if ($state.find('option[value="' + state + '"]').length) {
                        setSelectValue($state, state);
                        clearInterval(timer);
                    }

                    if (attempts > 25) {
                        console.warn('State not found:', state);
                        clearInterval(timer);
                    }
                }, 100);
            }

            function fillShippingForm(address) {
                if (!address) return;

                $('#shipping_first_name').val(address.first_name || '');
                $('#shipping_last_name').val(address.last_name || '');
                $('#shipping_phone').val(address.phone || '');
                $('#shipping_address_1').val(address.address_1 || '');
                $('#shipping_address_2').val(address.address_2 || '');
                $('#shipping_city').val(address.city || '');
                $('#shipping_postcode').val(address.postcode || '');

                // COUNTRY (first)
                if (address.country) {
                    setSelectValue($('#shipping_country'), address.country);
                }

                // STATE (after country rerender)
                if (address.state) {
                    waitAndSetState(address.state);
                }
            }

            function applySelectedShippingAddress() {
                const address = getAddressFromShippingSelect();
                if (!address) return;

                fillShippingForm(address);
            }

            // INIT
            $(function () {
                applySelectedShippingAddress();

                // on Select2 change
                $('#shippingAddressName').on('change select2:select', function () {
                    applySelectedShippingAddress();
                });
            });

        })(jQuery);


    </script>
<?php } ?>




<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ]  -->