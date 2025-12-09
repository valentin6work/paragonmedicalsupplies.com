<?php
/**
 * Template Name: Checkout page
 *
 *
 */
get_header();

$contact_info = get_field('contact_info',get_the_ID());
$form_data = get_field('form_data',get_the_ID());

?>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<?php
    if ( is_checkout() && !is_order_received_page() ) {
?>
    <div class="wrapper">
        <main class="page">
            <section class="checkout-section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="checkout__wrap">
                                <?php
                                    get_template_part( 'theme_templates/global/breadcrumbs_page');
                                ?>
                                <article class="checkout__content">
                                    <div class="entry-content">

                                        <div data-block-name="woocommerce/checkout"
                                             class="wp-block-woocommerce-checkout alignwide wc-block-checkout">
                                            <div class="with-scroll-to-top__scroll-point" aria-hidden="true"></div>
                                            <div class="wc-block-components-notices"></div>
                                            <div class="wc-block-components-notices__snackbar wc-block-components-notice-snackbar-list" tabindex="-1">
                                                <div></div>
                                            </div>

                                            <div class="wc-block-components-sidebar-layout wc-block-checkout is-large">
                                                <?php the_content();?>
                                            </div>

                                        </div>

                                    </div>
                                </article>
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

    <script>
        jQuery(function($){

            $(document).on('change', '#shipping_country', function() {

                let country = $(this).val();

                $.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    method: 'POST',
                    data: {
                        action: 'get_states',
                        country: country
                    },
                    success: function(states){

                        let $state = $('#shipping_state');

                        $state.empty();

                        if( Object.keys(states).length === 0 ){
                            $state.append('<option value="">No states required</option>');
                            $state.trigger('change');
                            return;
                        }
                        $state.append('<option value="">Select state</option>');

                        $.each(states, function(code, name){
                            $state.append('<option value="'+code+'">'+name+'</option>');
                        });

                        $state.trigger('change');
                    }
                });
            });

        });

    </script>
<?php
    }

    if (is_order_received_page()) {
?>
        <div class="wrapper">
            <main class="page">
                <section class="order-received-section">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <?php
                                    get_template_part( 'theme_templates/global/breadcrumbs_page');
                                ?>
                                <?php the_content();?>
                            </div>
                        </div>
                    </div>
                </section>

                <?php
                    get_template_part( 'theme_templates/global/contacts');
                ?>
            </main>
        </div>
<?php } ?>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>]  -->
<?php
get_footer();
?>