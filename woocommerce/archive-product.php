<?php
    get_header();
    $shop_page_id = wc_get_page_id( 'shop' );
    $background = get_field('background',$shop_page_id);
?>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
    <div class="wrapper">
        <main class="page">
            <section class="banner__section" style="background-image: url(<?php echo $background['url'];?>)">
                <?php
                    get_template_part( 'theme_templates/global/breadcrumbs_shop');
                ?>
            </section>

            <section class="shop__categories">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="shop-categories__wrap">
                                <?php
                                    $category = get_field('category',$shop_page_id);

                                    if ( is_array($category) && count($category) )
                                    {
                                        foreach ($category as $key => $item)
                                        {
                                            $imt=get_field('shop_image',$item);
                                            $im=get_image($imt,'',1);
                                            $term_link = get_term_link($item->term_id);
                                            echo " <a href=\"$term_link\" class=\"shop-categories__item\">
                                                       $im
                                                        <h3>$item->name</h3>
                                                        <div class=\"btn-main btn-small\">Shop Now</div>
                                                    </a> ";
                                        }
                                    }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="logo-slider__section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2><?php echo get_field('brands_title',$shop_page_id);?></h2>
                            <!-- Slider main container -->
                            <div class="swiper swiper-logo">
                                <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <!-- Slides -->
                                    <?php
                                    $repeater= get_field('brands',$shop_page_id);
                                    if ( is_array($repeater) && count($repeater) )
                                    {
                                        foreach ($repeater as $key => $item)
                                        {
                                            $im=get_image($item['logo'],'',1);
                                            echo " <div class=\"swiper-slide slide__logo\">
                                                   $im
                                                </div>
                                               ";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- If we need navigation -->
                            <div class="swiper-pagination pagination-logo pagination__styles"></div>
                        </div>
                    </div>
                </div>
            </section>

            <?php
                get_template_part( 'theme_templates/global/testimonials');
                get_template_part( 'theme_templates/global/contacts');
            ?>
        </main>
    </div>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  ]-->
<?php
get_footer();
?>