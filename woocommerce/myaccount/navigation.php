<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

/*echo '<pre>';
print_r(wc_get_account_menu_items());
echo '</pre>';*/

?>

<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->


<nav class="woocommerce-MyAccount-navigation">
    <ul>
        <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <?php
                switch ($endpoint){
                    case 'dashboard':
                        ?>
                        <li
                                class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                            <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span><?php echo esc_html( $label ); ?></span><img src="<?php echo theme_url;?>/img/dashboard-icon.svg" alt="icon"></a>
                        </li>
                    <?php
                        break;

                    case 'orders':
                        ?>
                        <li
                                class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                            <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span><?php echo esc_html( $label ); ?></span><img src="<?php echo theme_url;?>/img/orders-icon.svg" alt="icon"></a>
                        </li>
                        <?php
                        break;
                    case 'my_invoice':
                        ?>
                        <li
                                class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                            <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span>Your Invoice</span><img src="<?php echo theme_url;?>/img/invoices-icon.svg" alt="icon"></a>
                        </li>
                        <?php
                        break;
                    case 'edit-address':
                        ?>
                        <li
                                class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                            <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span><?php echo esc_html( $label ); ?></span><img src="<?php echo theme_url;?>/img/addresses-icon.svg" alt="icon"></a>
                        </li>
                        <?php
                        break;

                    case 'account_info':
                        ?>
                        <li
                                class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                            <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span>Account Info</span><img src="<?php echo theme_url;?>/img/account-info-icon.svg" alt="icon"></a>
                        </li>
                        <?php
                        break;
                    case 'customer-logout':
                        ?>
                        <li
                                class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                            <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span><?php echo esc_html( $label ); ?></span><img src="<?php echo theme_url;?>/img/logout.svg" alt="icon"></a>
                        </li>
                        <?php
                        break;
                }
            ?>

        <?php endforeach; ?>
    </ul>
    <div class="swiper user-account-slider">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->

            <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
                <?php
                switch ($endpoint){
                    case 'dashboard':
                        ?>
                        <div class="swiper-slide">
                               <div class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                            <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span><?php echo esc_html( $label ); ?></span><img src="<?php echo theme_url;?>/img/dashboard-icon.svg" alt="icon"></a>
                               </div>
                        </div>
                        <?php
                        break;

                    case 'orders':
                        ?>
                        <div class="swiper-slide">
                            <div
                                    class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                                <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span><?php echo esc_html( $label ); ?></span><img src="<?php echo theme_url;?>/img/orders-icon.svg" alt="icon"></a>
                            </div>
                        </div>
                        <?php
                        break;
                    case 'downloads':
                        ?>
                        <div class="swiper-slide">
                                    <div
                                            class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span><?php echo esc_html( $label ); ?></span><img src="<?php echo theme_url;?>/img/invoices-icon.svg" alt="icon"></a>
                                    </div>
                        </div>
                        <?php
                        break;
                    case 'edit-address':
                        ?>
                        <div class="swiper-slide">
                                    <div
                                            class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span><?php echo esc_html( $label ); ?></span><img src="<?php echo theme_url;?>/img/addresses-icon.svg" alt="icon"></a>
                                    </div>
                        </div>
                        <?php
                        break;

                    case 'edit-account':
                        ?>
                        <div class="swiper-slide">
                                    <div
                                            class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span><?php echo esc_html( $label ); ?></span><img src="<?php echo theme_url;?>/img/account-info-icon.svg" alt="icon"></a>
                                    </div>
                        </div>
                        <?php
                        break;
                    case 'customer-logout':
                        ?>
                        <div class="swiper-slide">
                                    <div
                                            class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span><?php echo esc_html( $label ); ?></span><img src="<?php echo theme_url;?>/img/logout.svg" alt="icon"></a>
                                    </div>
                        </div>
                        <?php
                        break;
                }
                ?>

            <?php endforeach; ?>

        </div>
        <div class="swiper-pagination pagination__user-account pagination__styles"></div>
    </div>
</nav>

<?php return;?>

<nav class="woocommerce-MyAccount-navigation" aria-label="<?php esc_html_e( 'Account pages', 'woocommerce' ); ?>">
	<ul>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" <?php echo wc_is_current_account_menu_item( $endpoint ) ? 'aria-current="page"' : ''; ?>>
					<?php echo esc_html( $label ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>

<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->