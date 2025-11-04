<?php
/**
 * Template Name: Frogot pass page
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
        <section class="forgot-passw-section log-reg__section-style">
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
                            <form class="forgot-password__form form__input-style white-bg" action="#" method="post">
                                <p class="input__full-width">
                                    <label for="forgotPasswEmail">Enter your email address below to receive a password reset link.</label>
                                    <input type="email" class="mail" name="loginEmail" value="" placeholder="E-mail" id="forgotPasswEmail" required>
                                </p>

                                <div class="form__error"></div>
                                <div class="form__success"></div>

                                <button type="submit" class="button wp-element-button btn-main btn-large"
                                        name="log_in" value="Log in">Reset password</button>
                            </form>
                            <div class="log__acc-wrap">
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