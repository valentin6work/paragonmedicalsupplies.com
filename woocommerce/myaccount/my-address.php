<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}

$oldcol = 1;
$col    = 1;

$user_id = intval(get_current_user_id());
$user_cart_list = get_user_meta($user_id, 'user_cart_list', true);
$shipping_field_saved = get_user_meta($user_id, 'shipping_field_saved', true);
$billing_field_saved = get_user_meta($user_id, 'billing_field_saved', true);

?>
    <!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->

<div class="my-account__wrap white-bg">
    <h1>Shipping &amp; Billing</h1>
    <div class="shipping-and-billing__block-wrap">
        <div class="shipping-and-billing__block">
            <h2>Payment Methods</h2>

            <div class="shipping-and-billing__block-data">

                <?php
                if (is_array($user_cart_list) && count($user_cart_list) )
                {
                    $ctype=[
                        'visa'=>'visa.svg',
                        'mastercard'=>'mastercard.svg',
                    ];

                   foreach ($user_cart_list as $key=>$cart)
                   {
                       $cnum = $cart['cart_number'];
                       $ctp = $ctype[$cart['type_cart']];
                       switch ($cart['set_cart_default'])
                       {
                           case 1:
                               $def = "
                            <button class=\"address-default-button default-active dis_cart_default\" >Default</button>
                       ";
                               break;
                           case 0:
                               $def = "
                            <button class=\"address-default-button set_cart_default\" data-indx='$key' >Set as default  </button>
                       ";
                               break;
                       }


                       echo "
                         <!-- shipping-and-billing__block -->
                            <div class=\"shipping-and-billing__block-row\" >
            
                                <div class=\"shipping-and-billing__block-col\">
                                    <div class=\"shipping-and-billing__card\">
                                        <img src=\"".theme_url."/img/$ctp\" alt=\"visa\">
                                        <p>$cnum</p>
                                    </div>
                                </div>
                                <div class=\"shipping-and-billing__block-col\">
                                    <span class=\"expired\">Expired on $cart[cart_expired]</span>
                                </div>
                                <div class=\"shipping-and-billing__block-col\">
                                    <div class=\"shipping-and-billing__block-action\">
                                        $def
                                        <button class=\"remove-btn delete_cart\" data-indx='$key'>
                                            <img src=\"".theme_url."/img/close_filter_cell.svg\" alt=\"icon\">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- /shipping-and-billing__block -->
                       ";
                   }
                }
                ?>

                <!-- adding shipping-and-billing__block  -->
                <div class="shipping-and-billing__block-row add_cart" >

                    <div class="shipping-and-billing__block-col">
                        <div class="shipping-and-billing__card">
                            <p>
                                <select name="type_cart" id="type_cart">
                                    <option value="">Select type card</option>
                                    <option value="visa">Visa</option>
                                    <option value="mastercard">Mastercard</option>
                                </select>
                            </p>
                            <p>
                                <input type="text" placeholder="Card number" name="cart_number" id="cart_number">
                            </p>
                        </div>
                    </div>
                    <div class="shipping-and-billing__block-col">
                        <p>
                            Expired
                            <input type="text" placeholder="09/26" name="cart_expired" id="cart_expired">
                        </p>
                    </div>
                </div>
                <!-- /adding shipping-and-billing__block  -->

            </div>

            <a href="#" class="btn-main btn-small" id="add_new_card">Add new card</a>

        </div>

        <div class="shipping-and-billing__block">
            <h2>Shipping Address</h2>
            <div class="shipping-and-billing__block-data">

                <?php
                if (is_array($shipping_field_saved) && count($shipping_field_saved) )
                {
                    foreach ($shipping_field_saved as $key=>$field)
                    {
                        $def='';
                        switch ($field['set_default'])
                        {
                            case 1:
                                $def = "
                            <button class=\"address-default-button default-active\" >Default</button>
                       ";
                                break;
                            case 0:
                                $def = "
                            <button class=\"address-default-button set_ship_default\" data-indx='$key' >Set as default  </button>
                       ";
                                break;
                        }


                        echo "
                         <!-- shipping Address __block -->
                         
                         <div class=\"shipping-and-billing__block-row\">
                                <div class=\"shipping-and-billing__block-col\">
                                    <div class=\"shipping-and-billing__name\">
                                        <p>$field[shipping_first_name]</p>
                                        <p>$field[shipping_phone]</p>
                                    </div>
                                </div>
                                <div class=\"shipping-and-billing__block-col\">
                                    <address>$field[shipping_address_1]</address>
                                </div>
                                <div class=\"shipping-and-billing__block-col\">
                                    <div class=\"shipping-and-billing__block-action\">
                                        
                                       $def
                                        
                                        <a href=\"#\" class=\"edit-link edit_shipp_addr\"
                                            data-shipping_first_name='$field[shipping_first_name]'
                                            data-shipping_phone='$field[shipping_phone]'
                                            data-shipping_address_1='$field[shipping_address_1]'
                                            data-set_default='$field[set_default]'
                                            data-indx='$key'
                                        >
                                        Edit
                                        </a>
                                        
                                        <button class=\"remove-btn remove_shipping_address\" data-indx='$key' >
                                            <img src=\"".theme_url."/img/close_filter_cell.svg\" alt=\"icon\">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- /shipping Address __block -->
                       ";
                    }
                }
                ?>

                <!-- add shipping Address -->
                <div class="shipping-and-billing__block-row add_shipping_field_custom">
                    <input type="hidden" id="shipping_is_edit" name="shipping_is_edit" value="0" >
                    <input type="hidden" id="shipping_edit_idx" name="shipping_edit_idx" value="" >

                    <div class="shipping-and-billing__block-col">
                        <div class="shipping-and-billing__name">
                            <p> <input type="text" placeholder="First name" name="shipping_first_name" id="shipping_first_name"> </p>
                            <p> <input type="text" placeholder="Phone" name="shipping_phone" id="shipping_phone"></p>
                        </div>
                    </div>
                    <div class="shipping-and-billing__block-col">
                        <address><input type="text" placeholder="Street address" name="shipping_address_1" id="shipping_address_1"></address>
                    </div>

                </div>
                <!-- /add shipping Address -->

            </div>
            <a href="#" class="btn-main btn-small" id="btn_add_shipping_field_cust">Add new address</a>

        </div>

        <div class="shipping-and-billing__block">
            <h2>Billing Address</h2>
            <div class="shipping-and-billing__block-data">

                <?php
                if (is_array($billing_field_saved) && count($billing_field_saved) )
                {
                    foreach ($billing_field_saved as $key=>$field)
                    {
                        $def='';
                        switch ($field['set_default'])
                        {
                            case 1:
                                $def = "
                            <button class=\"address-default-button default-active\" >Default</button>
                       ";
                                break;
                            case 0:
                                $def = "
                            <button class=\"address-default-button set_bill_default\" data-indx='$key' >Set as default  </button>
                       ";
                                break;
                        }


                        echo "
                         <!-- billing Address __block -->
                         
                         <div class=\"shipping-and-billing__block-row\">
                                <div class=\"shipping-and-billing__block-col\">
                                    <div class=\"shipping-and-billing__name\">
                                        <p>$field[billing_first_name]</p>
                                        <p>$field[billing_phone]</p>
                                    </div>
                                </div>
                                <div class=\"shipping-and-billing__block-col\">
                                    <address>$field[billing_address_1]</address>
                                </div>
                                <div class=\"shipping-and-billing__block-col\">
                                    <div class=\"shipping-and-billing__block-action\">
                                        
                                       $def
                                        
                                        <a href=\"#\" class=\"edit-link edit_billing_addr\"
                                            data-billing_first_name='$field[billing_first_name]'
                                            data-billing_phone='$field[billing_phone]'
                                            data-billing_address_1='$field[billing_address_1]'
                                            data-set_default='$field[set_default]'
                                            data-indx='$key'
                                        >
                                        Edit
                                        </a>
                                        
                                        <button class=\"remove-btn remove_billing_address\" data-indx='$key' >
                                            <img src=\"".theme_url."/img/close_filter_cell.svg\" alt=\"icon\">
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- /billing Address __block -->
                       ";
                    }
                }
                ?>
                <!-- add billing Address -->
                <div class="shipping-and-billing__block-row add_shipping_field_custom">
                    <input type="hidden" id="billing_is_edit" name="billing_is_edit" value="0" >
                    <input type="hidden" id="billing_edit_idx" name="billing_edit_idx" value="" >

                    <div class="shipping-and-billing__block-col">
                        <div class="shipping-and-billing__name">
                            <p> <input type="text" placeholder="First name" name="billing_first_name" id="billing_first_name"> </p>
                            <p> <input type="text" placeholder="Phone" name="billing_phone" id="billing_phone"></p>
                        </div>
                    </div>
                    <div class="shipping-and-billing__block-col">
                        <address><input type="text" placeholder="Street address" name="billing_address_1" id="billing_address_1"></address>
                    </div>


                </div>
                <!-- /add billing Address -->

            </div>
            <a href="#" class="btn-main btn-small" id="btn_add_billing_field_cust" >Add new address</a>
        </div>
    </div>
</div>

<?php return;?>

<p>
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'woocommerce' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	<div class="u-columns woocommerce-Addresses col2-set addresses">
<?php endif; ?>

<?php foreach ( $get_addresses as $name => $address_title ) : ?>
	<?php
		$address = wc_get_account_formatted_address( $name );
		$col     = $col * -1;
		$oldcol  = $oldcol * -1;
	?>

	<div class="u-column<?php echo $col < 0 ? 1 : 2; ?> col-<?php echo $oldcol < 0 ? 1 : 2; ?> woocommerce-Address">
		<header class="woocommerce-Address-title title">
			<h2><?php echo esc_html( $address_title ); ?></h2>
			<a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit">
				<?php
					printf(
						/* translators: %s: Address title */
						$address ? esc_html__( 'Edit %s', 'woocommerce' ) : esc_html__( 'Add %s', 'woocommerce' ),
						esc_html( $address_title )
					);
				?>
			</a>
		</header>
		<address>
			<?php
				echo $address ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'woocommerce' );

				/**
				 * Used to output content after core address fields.
				 *
				 * @param string $name Address type.
				 * @since 8.7.0
				 */
				do_action( 'woocommerce_my_account_after_my_address', $name );
			?>
		</address>
	</div>

<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	</div>
	<?php
endif;

?>

<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>] -->
