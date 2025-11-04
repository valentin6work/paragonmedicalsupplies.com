<?php
/**
 * Template Name: Login page
 *
 *
 */
get_header();

$contact_info = get_field('contact_info',get_the_ID());
$form_data = get_field('form_data',get_the_ID());

?>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<div class="wrapper">
        <main class="page">
            <section class="login-section log-reg__section-style">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="login-section__img">
                                <?php
                                    echo get_image(get_field('image',get_the_ID()),'',1);
                                ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 align-self-center">
                            <div class="login-section__content">
                                <h1><?php the_title();?></h1>
                                <form class="login__form form__input-style white-bg" action="#" method="post" id="login_form">
                                    <p class="input__full-width">
                                        <input type="email" class="mail" name="loginEmail" value="" placeholder="E-mail" required>
                                    </p>
                                    <p class="input__full-width">
                                    <span class="password-input">
                                        <input type="password" class="passw input__password woocommerce-Input woocommerce-Input--text input-text" name="password" id="password" placeholder="Password" autocomplete="current-password" required>
                                    <span class="show-password-input"></span></span>
                                    </p>
                                    <div class="checkbox__row-wrap">
                                        <div class="custom-checkbox">
                                            <input type="checkbox" name="checkBox" id="checkBox">
                                            <label for="checkBox">Remember me</label>
                                        </div>
                                        <a href="<?php echo get_permalink(328);?>" class="form__link">Forgot your password?</a>
                                    </div>

                                    <div class="form__error"></div>
                                    <div class="form__success"></div>

                                    <button type="submit" class="button wp-element-button btn-main btn-large"
                                            name="log_in" value="Log in">Login</button>
                                </form>



                                <div class="log__acc-wrap">
                                    <p>Or continue with</p>
                                    <div class="log-acc__btn-wrap">
                                        <a href="#" class="product-btn-border btn-filter-img btn-filter-img"><img src="<?php echo theme_url;?>/img/facebook-app-symbol.svg" alt=""><span>facebook</span></a>
                                        <a href="#" class="product-btn-border btn-filter-img btn-filter-img"><img src="<?php echo theme_url;?>/img/google.svg" alt=""><span>Google</span></a>
                                    </div>
                                    <p>Don't have an account? <a href="<?php echo get_permalink(326);?>" class="form__link">Register</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
                get_template_part( 'theme_templates/global/contacts');
            ?>
        </main>
    </div>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>]  -->
<?php
get_footer();
?>