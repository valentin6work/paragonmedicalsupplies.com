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

        <!-- old adress -->

        <?php if (2<1) {  ?>
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

        <?php } ?>
        <!-- old /adress -->

        <!-- new logic adress -->

            <!-- shipping -->
            <div class="shipping-and-billing__block">
                <h2>Shipping Address</h2>
                <div class="shipping-and-billing__block-data">

                   <!-- out list -->
                    <?php
                    $addresses = $shipping_field_saved;

                    if (is_array($addresses) && count($addresses) )
                    foreach ($addresses as $idx => $addr) :

                        $full_name = trim(($addr['first_name'] ?? '') . ' ' . ($addr['last_name'] ?? ''));
                        $phone     = $addr['phone'] ?? '';
                        $address_1 = $addr['address_1'] ?? '';
                        $city      = $addr['city'] ?? '';
                        $state     = $addr['state'] ?? '';
                        $postcode  = $addr['postcode'] ?? '';

                        $is_default = !empty($addr['is_default']);
                        ?>

                        <div class="shipping-and-billing__block-row" <div class="shipping-and-billing__block-row"
                                                                          data-address='<?php echo esc_attr(json_encode($addr)); ?>'
                                                                          data-address-id="<?php echo esc_attr($idx); ?>">


                            <div class="shipping-and-billing__block-col">
                                <div class="shipping-and-billing__name">
                                    <small><?php echo esc_html($addr['address_name']); ?></small>
                                    <p><?php echo esc_html($full_name); ?></p>
                                    <p><?php echo esc_html($phone); ?></p>
                                </div>
                            </div>

                            <div class="shipping-and-billing__block-col">
                                <address>
                                    <?php echo esc_html($address_1); ?><br>
                                    <?php echo esc_html("$city, $state $postcode"); ?>
                                </address>
                            </div>

                            <div class="shipping-and-billing__block-col">
                                <div class="shipping-and-billing__block-action">

                                    <button
                                            class="address-default-button <?php echo $is_default ? 'default-active' : ''; ?>"
                                            data-address-id="<?php echo esc_attr($idx); ?>">
                                        Default
                                    </button>

                                    <a href="#"
                                       class="edit-link shipping-edit-link"
                                       data-address-id="<?php echo esc_attr($idx); ?>">
                                        Edit
                                    </a>

                                    <button
                                            class="remove-btn"
                                            data-address-id="<?php echo esc_attr($idx); ?>">
                                        <img src="<?php echo get_template_directory_uri(); ?>/img/close_filter_cell.svg" alt="icon">
                                    </button>

                                </div>
                            </div>

                        </div>

                    <?php endforeach; ?>

                    <!-- /out list -->


                    <form action="#" method="post" class="shipping-and-billing__block-row add_shipping_field_custom form__input-style" id="shipping_block_adress" >
                        <input type="hidden" id="shipping_is_edit" name="shipping_is_edit" value="0">
                        <input type="hidden" id="shipping_edit_idx" name="shipping_edit_idx" value="">

                        <label for="shipping_address_name">Address Name<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_first_name"><input type="text" id="shipping_address_name" name="shipping_address_name" value="" placeholder="" required></div></label>

                        <label for="shipping_phone">Phone Number<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_phone"><input type="text" id="shipping_phone" name="shipping_phone" value="" placeholder="" required autocomplete="tel"></div></label>

                        <label for="shipping_first_name">First name<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_first_name"><input type="text" id="shipping_first_name" name="shipping_first_name" value="" placeholder="" required autocomplete="given-name"></div></label>

                        <label for="shipping_last_name">Last name<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_last_name"><input type="text" id="shipping_last_name" name="shipping_last_name" value="" placeholder="" required autocomplete="family-name"></div></label>

                        <label for="shipping_country" class="full-width">Shipping Country<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_country ">
                                <select id="shipping_country" name="shipping_country" class="js-example-basic-single select2-hidden-accessible" required="" data-select2-id="select2-data-shipping_country" tabindex="-1" aria-hidden="true"><option value="">Select a country</option><option value="AF">Afghanistan</option><option value="AX">Åland Islands</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua and Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="PW">Belau</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BQ">Bonaire, Saint Eustatius and Saba</option><option value="BA">Bosnia and Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="BN">Brunei</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos (Keeling) Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CG">Congo (Brazzaville)</option><option value="CD">Congo (Kinshasa)</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CW">Curaçao</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="SZ">Eswatini</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard Island and McDonald Islands</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IM">Isle of Man</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="CI">Ivory Coast</option><option value="JM" data-select2-id="select2-data-2-a0y3">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="XK">Kosovo</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Laos</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macao</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="KP">North Korea</option><option value="MK">North Macedonia</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PS">Palestinian Territory</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russia</option><option value="RW">Rwanda</option><option value="ST">São Tomé and Príncipe</option><option value="BL">Saint Barthélemy</option><option value="SH">Saint Helena</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="SX">Saint Martin (Dutch part)</option><option value="MF">Saint Martin (French part)</option><option value="PM">Saint Pierre and Miquelon</option><option value="VC">Saint Vincent and the Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia/Sandwich Islands</option><option value="KR">South Korea</option><option value="SS">South Sudan</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard and Jan Mayen</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syria</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="TL">Timor-Leste</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad and Tobago</option><option value="TN">Tunisia</option><option value="TR">Türkiye</option><option value="TM">Turkmenistan</option><option value="TC">Turks and Caicos Islands</option><option value="TV">Tuvalu</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom (UK)</option><option value="US">United States (US)</option><option value="UM">United States (US) Minor Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VA">Vatican</option><option value="VE">Venezuela</option><option value="VN">Vietnam</option><option value="VG">Virgin Islands (British)</option><option value="VI">Virgin Islands (US)</option><option value="WF">Wallis and Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option></select></div></label>

                        <label for="shipping_address_1">Street address<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_address_1 "><input type="text" id="shipping_address_1" name="shipping_address_1" value="" placeholder="House number and street name" required autocomplete="address-line1"></div></label>

                        <label for="shipping_address_2">Apartment, suite, unit, etc.<div class="wc-block-components-text-input wc-block-components-address-form__shipping_address_2 "><input type="text" id="shipping_address_2" name="shipping_address_2" value="" placeholder="Apartment, suite, unit, etc. (optional)" autocomplete="address-line2"></div></label>

                        <label for="shipping_city">Town / City<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_city "><input type="text" id="shipping_city" name="shipping_city" value="" placeholder="" required autocomplete="address-level2"></div></label>

                        <label for="shipping_state" class="full-width">Shipping State/Province<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_state"><select id="shipping_state" name="shipping_state" class="js-example-basic-single select2-hidden-accessible" required data-select2-id="select2-data-shipping_state" tabindex="-1" aria-hidden="true"><option value="" selected="selected" data-select2-id="select2-data-4-donn">Select a state</option><option value="JM-01">Kingston</option><option value="JM-02">Saint Andrew</option><option value="JM-03">Saint Thomas</option><option value="JM-04">Portland</option><option value="JM-05">Saint Mary</option><option value="JM-06">Saint Ann</option><option value="JM-07">Trelawny</option><option value="JM-08">Saint James</option><option value="JM-09">Hanover</option><option value="JM-10">Westmoreland</option><option value="JM-11">Saint Elizabeth</option><option value="JM-12">Manchester</option><option value="JM-13">Clarendon</option><option value="JM-14">Saint Catherine</option></select></div></label>

                        <label for="shipping_postcode">Postcode / ZIP<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_postcode"><input type="text" id="shipping_postcode" name="shipping_postcode" value="" placeholder="" required autocomplete="postal-code"></div></label>

                        <div class="btn-save">

                            <button type="button" class="btn-main btn-small" id="btn_add_shipping_field_cust_custom">Save</button>

                        </div>

                    </form>
                </div>
                <a href="#" class="btn-main btn-small btn-add-address">Add new address</a>
            </div>
            <!-- /shipping -->

            <!-- billing -->
            <div class="shipping-and-billing__block">
                <h2>Billing Address</h2>
                <div class="shipping-and-billing__block-data">
                    <!-- out list -->

                    <?php
                    $user_id = get_current_user_id();

                    $addresses = $billing_field_saved;

                    if (is_array($addresses) && count($addresses))
                    foreach ($addresses as $idx => $addr) :

                        $full_name = trim(
                            ($addr['first_name'] ?? '') . ' ' . ($addr['last_name'] ?? '')
                        );

                        $phone    = $addr['phone'] ?? '';
                        $address1 = $addr['address_1'] ?? '';
                        $city     = $addr['city'] ?? '';
                        $state    = $addr['state'] ?? '';
                        $postcode = $addr['postcode'] ?? '';

                        $is_default = !empty($addr['is_default']);
                        ?>

                        <div class="billing-row shipping-and-billing__block-row"
                             data-address-id="<?php echo esc_attr($idx); ?>"
                             data-address='<?php echo esc_attr(wp_json_encode($addr)); ?>'>

                            <!-- NAME / PHONE -->
                            <div class="shipping-and-billing__block-col">
                                <div class="shipping-and-billing__name">
                                    <small><?php echo esc_html($addr['address_name']); ?></small>
                                    <p><?php echo esc_html($full_name); ?></p>
                                    <p><?php echo esc_html($phone); ?></p>
                                </div>
                            </div>

                            <!-- ADDRESS -->
                            <div class="shipping-and-billing__block-col">
                                <address>
                                    <?php echo esc_html($address1); ?><br>
                                    <?php echo esc_html(trim("$city, $state $postcode")); ?>
                                </address>
                            </div>

                            <!-- ACTIONS -->
                            <div class="shipping-and-billing__block-col">
                                <div class="shipping-and-billing__block-action">

                                    <button
                                            class="address-default-button billing-default-button <?php echo $is_default ? 'default-active' : ''; ?>"
                                            data-address-id="<?php echo esc_attr($idx); ?>">
                                        Default
                                    </button>

                                    <a href="#"
                                       class="edit-link billing-edit-link"
                                       data-address-id="<?php echo esc_attr($idx); ?>">
                                        Edit
                                    </a>

                                    <button
                                            class="billing-remove-btn"
                                            data-address-id="<?php echo esc_attr($idx); ?>">
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/img/close_filter_cell.svg'); ?>" alt="icon">
                                    </button>

                                </div>
                            </div>

                        </div>

                    <?php endforeach; ?>

                    <!-- /out list -->

                    <form action="#" method="post" class="shipping-and-billing__block-row add_shipping_field_custom form__input-style" id="billing_block_adress" >
                        <input type="hidden" id="billing_is_edit" name="billing_is_edit" value="0">
                        <input type="hidden" id="billing_edit_idx" name="billing_edit_idx" value="">

                        <label for="billing_address_name">Address Name<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_first_name"><input type="text" id="billing_address_name" name="billing_address_name" value="" placeholder="" required></div></label>

                        <label for="billing_phone">Phone Number<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_phone"><input type="text" id="billing_phone" name="billing_phone" value="" placeholder="Phone Number" required autocomplete="tel"></div></label>

                        <label for="billing_first_name">First name<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_first_name"><input type="text" id="billing_first_name" name="billing_first_name" value="" placeholder="" required autocomplete="given-name"></div></label>

                        <label for="billing_last_name">Last name<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_last_name"><input type="text" id="billing_last_name" name="billing_last_name" value="" placeholder="" required autocomplete="family-name"></div></label>

                        <label for="billing_country" class="full-width">Billing Country<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_country ">
                                <select id="billing_country" name="billing_country" class="js-example-basic-single select2-hidden-accessible" required data-select2-id="select2-data-billing_country" tabindex="-1" aria-hidden="true"><option value="">Select a country</option><option value="AF">Afghanistan</option><option value="AX">Åland Islands</option><option value="AL">Albania</option><option value="DZ">Algeria</option><option value="AS">American Samoa</option><option value="AD">Andorra</option><option value="AO">Angola</option><option value="AI">Anguilla</option><option value="AQ">Antarctica</option><option value="AG">Antigua and Barbuda</option><option value="AR">Argentina</option><option value="AM">Armenia</option><option value="AW">Aruba</option><option value="AU">Australia</option><option value="AT">Austria</option><option value="AZ">Azerbaijan</option><option value="BS">Bahamas</option><option value="BH">Bahrain</option><option value="BD">Bangladesh</option><option value="BB">Barbados</option><option value="BY">Belarus</option><option value="PW">Belau</option><option value="BE">Belgium</option><option value="BZ">Belize</option><option value="BJ">Benin</option><option value="BM">Bermuda</option><option value="BT">Bhutan</option><option value="BO">Bolivia</option><option value="BQ">Bonaire, Saint Eustatius and Saba</option><option value="BA">Bosnia and Herzegovina</option><option value="BW">Botswana</option><option value="BV">Bouvet Island</option><option value="BR">Brazil</option><option value="IO">British Indian Ocean Territory</option><option value="BN">Brunei</option><option value="BG">Bulgaria</option><option value="BF">Burkina Faso</option><option value="BI">Burundi</option><option value="KH">Cambodia</option><option value="CM">Cameroon</option><option value="CA">Canada</option><option value="CV">Cape Verde</option><option value="KY">Cayman Islands</option><option value="CF">Central African Republic</option><option value="TD">Chad</option><option value="CL">Chile</option><option value="CN">China</option><option value="CX">Christmas Island</option><option value="CC">Cocos (Keeling) Islands</option><option value="CO">Colombia</option><option value="KM">Comoros</option><option value="CG">Congo (Brazzaville)</option><option value="CD">Congo (Kinshasa)</option><option value="CK">Cook Islands</option><option value="CR">Costa Rica</option><option value="HR">Croatia</option><option value="CU">Cuba</option><option value="CW">Curaçao</option><option value="CY">Cyprus</option><option value="CZ">Czech Republic</option><option value="DK">Denmark</option><option value="DJ">Djibouti</option><option value="DM">Dominica</option><option value="DO">Dominican Republic</option><option value="EC">Ecuador</option><option value="EG">Egypt</option><option value="SV">El Salvador</option><option value="GQ">Equatorial Guinea</option><option value="ER">Eritrea</option><option value="EE">Estonia</option><option value="SZ">Eswatini</option><option value="ET">Ethiopia</option><option value="FK">Falkland Islands</option><option value="FO">Faroe Islands</option><option value="FJ">Fiji</option><option value="FI">Finland</option><option value="FR">France</option><option value="GF">French Guiana</option><option value="PF">French Polynesia</option><option value="TF">French Southern Territories</option><option value="GA">Gabon</option><option value="GM">Gambia</option><option value="GE">Georgia</option><option value="DE">Germany</option><option value="GH">Ghana</option><option value="GI">Gibraltar</option><option value="GR">Greece</option><option value="GL">Greenland</option><option value="GD">Grenada</option><option value="GP">Guadeloupe</option><option value="GU">Guam</option><option value="GT">Guatemala</option><option value="GG">Guernsey</option><option value="GN">Guinea</option><option value="GW">Guinea-Bissau</option><option value="GY">Guyana</option><option value="HT">Haiti</option><option value="HM">Heard Island and McDonald Islands</option><option value="HN">Honduras</option><option value="HK">Hong Kong</option><option value="HU">Hungary</option><option value="IS">Iceland</option><option value="IN">India</option><option value="ID">Indonesia</option><option value="IR">Iran</option><option value="IQ">Iraq</option><option value="IE">Ireland</option><option value="IM">Isle of Man</option><option value="IL">Israel</option><option value="IT">Italy</option><option value="CI">Ivory Coast</option><option value="JM" data-select2-id="select2-data-2-a0y3">Jamaica</option><option value="JP">Japan</option><option value="JE">Jersey</option><option value="JO">Jordan</option><option value="KZ">Kazakhstan</option><option value="KE">Kenya</option><option value="KI">Kiribati</option><option value="XK">Kosovo</option><option value="KW">Kuwait</option><option value="KG">Kyrgyzstan</option><option value="LA">Laos</option><option value="LV">Latvia</option><option value="LB">Lebanon</option><option value="LS">Lesotho</option><option value="LR">Liberia</option><option value="LY">Libya</option><option value="LI">Liechtenstein</option><option value="LT">Lithuania</option><option value="LU">Luxembourg</option><option value="MO">Macao</option><option value="MG">Madagascar</option><option value="MW">Malawi</option><option value="MY">Malaysia</option><option value="MV">Maldives</option><option value="ML">Mali</option><option value="MT">Malta</option><option value="MH">Marshall Islands</option><option value="MQ">Martinique</option><option value="MR">Mauritania</option><option value="MU">Mauritius</option><option value="YT">Mayotte</option><option value="MX">Mexico</option><option value="FM">Micronesia</option><option value="MD">Moldova</option><option value="MC">Monaco</option><option value="MN">Mongolia</option><option value="ME">Montenegro</option><option value="MS">Montserrat</option><option value="MA">Morocco</option><option value="MZ">Mozambique</option><option value="MM">Myanmar</option><option value="NA">Namibia</option><option value="NR">Nauru</option><option value="NP">Nepal</option><option value="NL">Netherlands</option><option value="NC">New Caledonia</option><option value="NZ">New Zealand</option><option value="NI">Nicaragua</option><option value="NE">Niger</option><option value="NG">Nigeria</option><option value="NU">Niue</option><option value="NF">Norfolk Island</option><option value="KP">North Korea</option><option value="MK">North Macedonia</option><option value="MP">Northern Mariana Islands</option><option value="NO">Norway</option><option value="OM">Oman</option><option value="PK">Pakistan</option><option value="PS">Palestinian Territory</option><option value="PA">Panama</option><option value="PG">Papua New Guinea</option><option value="PY">Paraguay</option><option value="PE">Peru</option><option value="PH">Philippines</option><option value="PN">Pitcairn</option><option value="PL">Poland</option><option value="PT">Portugal</option><option value="PR">Puerto Rico</option><option value="QA">Qatar</option><option value="RE">Reunion</option><option value="RO">Romania</option><option value="RU">Russia</option><option value="RW">Rwanda</option><option value="ST">São Tomé and Príncipe</option><option value="BL">Saint Barthélemy</option><option value="SH">Saint Helena</option><option value="KN">Saint Kitts and Nevis</option><option value="LC">Saint Lucia</option><option value="SX">Saint Martin (Dutch part)</option><option value="MF">Saint Martin (French part)</option><option value="PM">Saint Pierre and Miquelon</option><option value="VC">Saint Vincent and the Grenadines</option><option value="WS">Samoa</option><option value="SM">San Marino</option><option value="SA">Saudi Arabia</option><option value="SN">Senegal</option><option value="RS">Serbia</option><option value="SC">Seychelles</option><option value="SL">Sierra Leone</option><option value="SG">Singapore</option><option value="SK">Slovakia</option><option value="SI">Slovenia</option><option value="SB">Solomon Islands</option><option value="SO">Somalia</option><option value="ZA">South Africa</option><option value="GS">South Georgia/Sandwich Islands</option><option value="KR">South Korea</option><option value="SS">South Sudan</option><option value="ES">Spain</option><option value="LK">Sri Lanka</option><option value="SD">Sudan</option><option value="SR">Suriname</option><option value="SJ">Svalbard and Jan Mayen</option><option value="SE">Sweden</option><option value="CH">Switzerland</option><option value="SY">Syria</option><option value="TW">Taiwan</option><option value="TJ">Tajikistan</option><option value="TZ">Tanzania</option><option value="TH">Thailand</option><option value="TL">Timor-Leste</option><option value="TG">Togo</option><option value="TK">Tokelau</option><option value="TO">Tonga</option><option value="TT">Trinidad and Tobago</option><option value="TN">Tunisia</option><option value="TR">Türkiye</option><option value="TM">Turkmenistan</option><option value="TC">Turks and Caicos Islands</option><option value="TV">Tuvalu</option><option value="UG">Uganda</option><option value="UA">Ukraine</option><option value="AE">United Arab Emirates</option><option value="GB">United Kingdom (UK)</option><option value="US">United States (US)</option><option value="UM">United States (US) Minor Outlying Islands</option><option value="UY">Uruguay</option><option value="UZ">Uzbekistan</option><option value="VU">Vanuatu</option><option value="VA">Vatican</option><option value="VE">Venezuela</option><option value="VN">Vietnam</option><option value="VG">Virgin Islands (British)</option><option value="VI">Virgin Islands (US)</option><option value="WF">Wallis and Futuna</option><option value="EH">Western Sahara</option><option value="YE">Yemen</option><option value="ZM">Zambia</option><option value="ZW">Zimbabwe</option></select></div></label>

                        <label for="billing_address_1">Street address<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_address_1 "><input type="text" id="billing_address_1" name="billing_address_1" value="" placeholder="House number and street name" required autocomplete="address-line1"></div></label>

                        <label for="billing_address_2">Apartment, suite, unit, etc.<div class="wc-block-components-text-input wc-block-components-address-form__shipping_address_2 "><input type="text" id="billing_address_2" name="shipping_address_2" value="" placeholder="Apartment, suite, unit, etc. (optional)" autocomplete="address-line2"></div></label>

                        <label for="billing_city">Town / City<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_city "><input type="text" id="billing_city" name="billing_city" value="" placeholder="" required autocomplete="address-level2"></div></label>

                        <label for="billing_state" class="full-width">Billing State/Province<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_state"><select id="billing_state" name="billing_state" class="js-example-basic-single select2-hidden-accessible" required="" data-select2-id="select2-data-billing_state" tabindex="-1" aria-hidden="true"><option value="" selected="selected" data-select2-id="select2-data-4-donn">Select a state</option><option value="JM-01">Kingston</option><option value="JM-02">Saint Andrew</option><option value="JM-03">Saint Thomas</option><option value="JM-04">Portland</option><option value="JM-05">Saint Mary</option><option value="JM-06">Saint Ann</option><option value="JM-07">Trelawny</option><option value="JM-08">Saint James</option><option value="JM-09">Hanover</option><option value="JM-10">Westmoreland</option><option value="JM-11">Saint Elizabeth</option><option value="JM-12">Manchester</option><option value="JM-13">Clarendon</option><option value="JM-14">Saint Catherine</option></select></div></label>

                        <label for="billing_postcode">Postcode / ZIP<span class="red__star">*</span><div class="wc-block-components-text-input wc-block-components-address-form__shipping_postcode"><input type="text" id="billing_postcode" name="billing_postcode" value="" placeholder="" required autocomplete="postal-code"></div></label>

                        <div class="btn-save">
                            <button type="button" class="btn-main btn-small" id="btn_add_billing_field_cust_custom" >Save</button>

                        </div>

                    </form>
                </div>

                <button class="btn-main btn-small btn-add-address">Add new address</button>
            </div>
            <!-- /billing -->

        <!-- /new logic adress -->

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
