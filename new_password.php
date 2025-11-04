<?php
/**
 * Template Name: New Password
 *
 *
 */

if (!is_user_logged_in()) {
    wp_redirect(home_url());
    exit();
}
get_header();

$setting = get_field('header','options');

$current_user = wp_get_current_user();
$user_email = $current_user->user_email;

?>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
    <div class="wrapper">
        <main class="page">

            <section class="new-passw__section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="new-passw__wrap">
                                <a class="new-passw__logo" href="<?php echo get_site_url();?>"><?php echo get_image($setting['logo'],''); ?></a>
                                <h1>New Password </h1>
                                <p class="new-passw__user-name">Enter a new password for <span> <?php echo $user_email;?></span></p>
                                <form class="new-passw__form form__input-style white-bg" action="#" method="post" id="set_new_password">
                                    <p class="input__full-width">
                                        <label for="password">New Password</label>
                                        <span class="password-input">
                                        <input type="password" class="passw input__password woocommerce-Input woocommerce-Input--text input-text" name="password" id="password" autocomplete="new-password" required="">
                                            <span class="show-password-input"></span>
                                        </span>
                                    </p>
                                    <p class="input__full-width">
                                        <label for="confPassword">Confirm New Password</label>
                                        <span class="password-input">
                                        <input type="password" class="passw input__password woocommerce-Input woocommerce-Input--text input-text" name="confPassword" id="confPassword" autocomplete="new-password" required="">
                                            <span class="show-password-input"></span>
                                        </span>
                                    </p>

                                    <div class="form__error"></div>
                                    <div class="form__success"></div>

                                    <button type="submit" class="button wp-element-button btn-main btn-large">Set password</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>
    </div>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>]  -->
<?php
get_footer();
?>