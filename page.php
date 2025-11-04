<?php
get_header();

$default_view_setting = get_field('default_view_setting','options');

?>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->

<div class="wrapper">
        <main class="page">
            <?php
                get_template_part( 'theme_templates/global/breadcrumbs');
            ?>
            <section class="privacy-policy__section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="privacy-policy__wrap">
                                <h1><?php the_title();?></h1>
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
</div>


<!-- <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>]  -->
<?php
get_footer();
?>