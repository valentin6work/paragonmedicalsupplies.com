<?php
/**
 * Template Name: Cart page
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
        <section class="cart-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cart__wrap">
                            <?php
                            get_template_part( 'theme_templates/global/breadcrumbs_page');
                            ?>
                            <h1 class="entry-title"><?php the_title();?></h1>

                            <div class="page-content">
                                <?php the_content();?>
                            </div>

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