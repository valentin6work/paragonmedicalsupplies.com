<?php
/**
 * Template Name: Page 404
 *
 *
 */

get_header();

$page404 = get_field('page404','options');

?>

<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
    <div class="wrapper">
        <main class="page">
            <section class="page404__section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="page404__wrap white-bg">
                                <?php
                                    echo get_image($page404['image'],'wow animate__animated animate__zoomIn',1);
                                ?>
                                <h2><?php
                                    echo $page404['title'];
                                    ?></h2>
                                <?php
                                    echo $page404['text'];
                                ?>
                                <a href="<?php echo $page404['button']['url'];?>" target="<?php echo $page404['button']['target'];?>" class="btn-main btn-border"><?php echo $page404['button']['title'];?></a>
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