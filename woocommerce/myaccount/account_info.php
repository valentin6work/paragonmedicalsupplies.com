<?php
/**
 * Account info - Custom
 *
 * @package WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

$current_user = wp_get_current_user();

$user_email = $current_user->user_email;

$shipping_phone = get_user_meta($current_user->ID, 'shipping_phone', true);
$first_name = get_user_meta($current_user->ID, 'shipping_first_name', true);
$last_name = get_user_meta($current_user->ID, 'shipping_last_name', true);

?>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<div class="my-account__wrap white-bg">
    <h1>Account Information</h1>
    <div class="account-info__wrap">
        <div class="account-info__pers-info">
            <h2>Personal Information</h2>
            <div class="pers-info__block">
                <div class="pers-info__data">
                    <div class="pers-info__data-row-wrap">
                        <div class="pers-info__data-row">
                            <p>Login email:</p>
                            <div class="pers-info-text login-email"><?php echo $user_email;?></div>
                        </div>
                        <div class="pers-info__data-row">
                            <p>First name:</p>
                            <div class="pers-info-text login-email"><?php echo $first_name;?></div>
                        </div>
                        <div class="pers-info__data-row">
                            <p>Last name:</p>
                            <div class="pers-info-text login-email"><?php echo $last_name;?></div>
                        </div>
                        <div class="pers-info__data-row">
                            <p>Phone:</p>
                            <div class="pers-info-text login-email"><?php echo $shipping_phone;?></div>
                        </div>
                        <a href="<?php echo wc_get_account_endpoint_url( 'edit-address' ); ?>" class="edit-link">Edit</a>
                    </div>

                    <a href="<?php echo get_permalink(504); ?>" class="btn-main btn-small">change password</a>
                </div>
            </div>
        </div>
        <div class="account-info__autor-users">
            <h2>Authorized Users</h2>
            <div class="my-account__table account-info-table">
                <ul class="my-account-table-row">
                    <li class="table-li-user">User</li>
                    <li class="table-li-last-login">Last login</li>
                    <li class="table-li-action">Action</li>
                </ul>

                <?php
                    echo display_last_five_logins();
                ?>

            </div>
        </div>
    </div>
</div>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->


