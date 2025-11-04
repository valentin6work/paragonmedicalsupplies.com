<?php
/**
 * Template Name: My account page
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
    <section class="user-account__section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <article>
                        <div class="entry-content">
                            <?php the_content();?>
                        </div>
                    </article>
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