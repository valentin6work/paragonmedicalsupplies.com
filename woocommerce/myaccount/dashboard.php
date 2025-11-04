<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);

$pers_disc =get_list_discount();


?>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->


    <div class="woocommerce-notices-wrapper"></div>
    <p>Hello, <?php echo $current_user->display_name;?>!</p>
    <div class="dashboard__discount-block white-bg">
        <div>
            <?php if($pers_disc) { ?>
                <p>Congratulation! You have a personal discount <?php echo $pers_disc;?>%.</p>
            <?php } ?>
        </div>
        <a href="<?php echo get_permalink(wc_get_page_id('shop'));?>" class="btn-main btn-border">shop now!</a>
    </div>

    <ul class="dashboard__links">

        <?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
            <?php
            switch ($endpoint){
                case 'dashboard1':
                    ?>
                    <li
                            class="dashboard-links__item">
                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                            <img src="<?php echo theme_url;?>/img/order-dashboard.svg" alt="icon">
                            <span>Your Orders</span>
                        </a>
                    </li>
                    <?php
                    break;

                case 'orders':
                    ?>
                    <li
                            class="dashboard-links__item">
                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><img src="<?php echo theme_url;?>/img/order-dashboard.svg" alt="icon">
                            <span>Your Orders</span>
                        </a>
                    </li>
                    <?php
                    break;
                case 'my_invoice':
                    ?>
                    <li class="dashboard-links__item">
                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>">
                            <img src="<?php echo theme_url;?>/img/invoice-dashboard.svg" alt="icon">
                            <span>Your Invoices</span>
                        </a>
                    </li>
                    <?php
                    break;
                case 'edit-address':
                    ?>
                    <li
                            class="dashboard-links__item">
                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><img src="<?php echo theme_url;?>/img/addresses-dashboard.svg" alt="icon"><span>Shipping & Billing Addresses</span></a>
                    </li>
                    <?php
                    break;

                case 'edit-account':
                    ?>
                    <li
                            class="dashboard-links__item">
                        <a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><img src="<?php echo theme_url;?>/img/dashboard-ac-info.svg" alt="icon">
                            <span>Your Account Information</span>
                        </a>
                    </li>
                    <?php
                    break;
            }
            ?>

        <?php endforeach; ?>

    </ul>


<?php
/**
 * My Account dashboard.
 *
 * @since 2.6.0
 */
do_action( 'woocommerce_account_dashboard' );

/**
 * Deprecated woocommerce_before_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action( 'woocommerce_before_my_account' );

/**
 * Deprecated woocommerce_after_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
?>

<?php return ;?>
<p>
	<?php
	printf(
		/* translators: 1: user display name 2: logout url */
		wp_kses( __( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ), $allowed_html ),
		'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
		esc_url( wc_logout_url() )
	);
	?>
</p>

<p>
	<?php
	/* translators: 1: Orders URL 2: Address URL 3: Account URL. */
	$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">billing address</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
	if ( wc_shipping_enabled() ) {
		/* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
		$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
	}
	printf(
		wp_kses( $dashboard_desc, $allowed_html ),
		esc_url( wc_get_endpoint_url( 'orders' ) ),
		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
		esc_url( wc_get_endpoint_url( 'edit-account' ) )
	);
	?>
</p>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
?>
<!-- <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>]  -->
