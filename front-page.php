<?php
/**
 * Template Name: Front page
 *
 *
 */
get_header();

$slider = get_field('slider',get_the_ID());
$banner = get_field('banner',get_the_ID());
$featured_categories = get_field('featured_categories',get_the_ID());
$shop_section = get_field('shop_section',get_the_ID());
$achievements = get_field('achievements',get_the_ID());
$brands = get_field('brands',get_the_ID());
//$customers_says = get_field('customers_says',get_the_ID());

$poster = get_field('poster',get_the_ID());
$microsoft_text = get_field('microsoft_text',get_the_ID());
$microsoft_accordion = get_field('microsoft_accordion',get_the_ID());
$schedule_section = get_field('schedule_section',get_the_ID());
$question_section = get_field('question_section',get_the_ID());
$partners_section= get_field('partners_section',get_the_ID());


?>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->

<div class="wrapper">
    <main class="page">

        <section class="hero">
            <div class="hero__wrap">
                <div class="swiper hero__slider white-bg">
                    <div class="swiper-wrapper">
                        <?php
                            $repeater= $slider['slider_items'];
                            if ( is_array($repeater) && count($repeater) )
                            {
                               foreach ($repeater as $key => $item)
                               {
                                   $im=get_image($item['image'],'',1);
                                   $btn=$item['button'];
                                   echo "
                                    <div class=\"swiper-slide hero__slide\">
                                        $im
                                        <div class=\"container\">
                                            <div class=\"hero__slide-wrap\">
                                                <div class=\"hero__status sale\">$item[status]</div>
                                                <h1 class=\"hero__title\">$item[title]</h1>
                                                <a href=\"$btn[url]\" target='$btn[target]' class=\"btn-main btn-large\">$btn[title]</a>
                                            </div>
                                        </div>
                                    </div>
                                   ";
                               }
                            }
                        ?>
                    </div>

                    <div class="swiper-pagination pagination-hero-slider pagination__styles"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>

                    <div class="banner">
                        <div class="banner-wrap">
                            <?php
                                echo get_image($banner['image'],'wow animate__animated animate__zoomIn',1);
                            ?>
                            <div class="banner__content">
                                <?php
                                    echo $banner['text'];
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        <section class="banner-mobile">
            <div class="container">
                <div class="row">
                    <div class="col-12">

                    </div>
                </div>
            </div>
        </section>

        <section class="featured-products">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>Featured Products</h2>
                        <div class="swiper products-slider description-text__wrap">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                <?php
                                    $args = array(
                                        'post_type'     => 'product',
                                        'posts_per_page' => 4,
                                        'orderby' => 'date',
                                        'order' => 'DESC',
                                    );

                                    $query = new WP_Query($args);
                                    $posts = $query->posts;

                                    if (is_array($posts) && count($posts))
                                    {
                                        foreach ($posts as $key => $item)
                                        {
                                            set_query_var('product_id', $item->ID);
                                            get_template_part('theme_templates/global/products_item');

                                            /*$product = wc_get_product($item->ID);
                                            $price = $product->get_price();
                                            $product_image = wp_get_attachment_image_url($product->get_image_id(), 'full'); // Картинка продукту

                                            $product_badge = get_field('product_badge',$item->ID);

                                            if ($product->is_type('variable'))
                                            {
                                                $available_variations = $product->get_available_variations();
                                                $variation = $available_variations[0];
                                                $price = $variation['display_price'];
                                                $add_to_cart_url = '?add-to-cart=' . $variation['variation_id'];
                                            } else {
                                                $add_to_cart_url = '?add-to-cart=' . $product->get_id();
                                            }

                                            $product_badge_html='';
                                            if ($product_badge)
                                            {
                                                $class=$product_badge['type'];
                                                $product_badge_html="
                                                    <span class=\"$class status__cart-product\">$product_badge[text]</span>
                                                ";
                                            }

                                            echo "
                                            <div class=\"swiper-slide\">
                                                <div class=\"product\">
                                                    <div class=\"product__properties\">
                                                       $product_badge_html
                                                        <div class=\"product__add-wishlist\">
                                                            <svg width=\"34.376\" height=\"30.88\" viewBox=\"0 0 34.376 30.88\">
                                                                <defs></defs>
                                                                <path data-name=\"Path 3\" d=\"M5.557,19.342A8.976,8.976,0,0,1,3,13.067,9.2,9.2,0,0,1,19.688,7.851a9.2,9.2,0,0,1,16.688,5.214,8.984,8.984,0,0,1-2.795,6.513L19.688,33.668Z\" transform=\"translate(-2.5 -3.5)\" stroke=\"#57606F\" stroke-width=\"1\" fill=\"#FF0000\"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <a href=\"" . get_permalink($item->ID) . "\" class=\"woocommerce-Loop woocommerce-loop-product__link\">
                                                        <div class=\"product-image\">
                                                            <img class=\"woocommerce-placeholder wp-post-image\" src=\"" . $product_image . "\" alt=\"image\">
                                                        </div>
                                                        <div class=\"woocommerce-loop-product__title\">" . get_the_title($item->ID) . "</div>
                                                    </a>
                                                    <div class=\"description__block\">
                                                        <p>" . $product->get_short_description() . "</p>
                                                    </div>
                                                    <span class=\"price\">
                                                        <span class=\"woocommerce-Price-amount amount\"><bdi><span class=\"woocommerce-Price-currencySymbol\">" . get_woocommerce_currency_symbol() . "</span>&nbsp;" . $price . "</bdi></span>
                                                    </span>
                                                    <div class=\"wp-block-button product-add-to-cart\">
                                                        <a href=\"" . $add_to_cart_url . "\" class=\"button product_type_simple add_to_cart_button ajax_add_to_cart\"><img src=\"".theme_url."/img/cart-white.svg\" alt=\"cart\"><span>Add to Cart</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        ";*/
                                        }
                                    }
                                ?>


                            </div>
                            <div class="swiper-pagination pagination__featured-products pagination__styles"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="featured-categories" style="background-image: url(<?php echo $featured_categories['background']['url'];?>);">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="featured-categories__wrap">
                            <h3 class="wow animate__animated animate__zoomIn" data-wow-delay="0"><?php echo nl2br($featured_categories['title']);?></h3>
                            <ul class="featured-categories__list">
                                <?php
                                    $repeater= $featured_categories['item'];
                                    if ( is_array($repeater) && count($repeater) )
                                    {
                                       foreach ($repeater as $key => $item)
                                       {
                                            $im = get_image($item['icon'],'',1);
                                            $category = $item['category'];

                                            $term = get_term($category);
                                            if (is_wp_error($term))
                                            {
                                                continue;
                                            }

                                            $tlink=get_term_link( $category );

                                            echo "
                                            <li class=\"featured-categories__item\">
                                                <a href=\"$tlink\">
                                                    $im
                                                    <h5>$category->name</h5>
                                                </a>
                                            </li>
                                            ";
                                       }
                                    }
                                ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="shop-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="shop-section__wrap">

                            <?php
                                $repeater= $shop_section['shop_items'];
                                if ( is_array($repeater) && count($repeater) )
                                {
                                   $delay=0;
                                   $cp=0;
                                   $out='';

                                   foreach ($repeater as $key => $item)
                                   {
                                       $cls='';
                                       $im=get_image($item['image'],'',1);
                                       $ln=$item['button'];
                                       $item['title']=nl2br($item['title']);

                                       if ($key==1  ) {
                                           $cls='white-bg';
                                       }
                                       $its.="
                                             <div class=\"shop-section__item $cls wow animate__animated animate__fadeInUp\" data-wow-delay=\"{$delay}s\">
                                                    $im
                                                    <h3>$item[title]</h3>
                                                    $item[text]
                                                    <a href=\"$ln[url]\" target='$ln[target]' class=\"btn-main btn-small\">$ln[title]</a>
                                                </div>
                                       ";
                                       $delay+=0.1;
                                       $cp++;

                                       if ($cp==2)
                                       {
                                           $out.="<div class=\"shop-section__row\">".$its.'</div>';
                                           $its='';
                                           $cp=0;
                                       }
                                   }

                                   echo $out;
                                }
                            ?>
                           <!-- <div class="shop-section__row">
                                <div class="shop-section__item wow animate__animated animate__fadeInUp" data-wow-delay="0">
                                    <img src="img/shop-section-img-1.jpg" alt="background">
                                    <h3>Stay prepared and protected with our top-quality rapid testing kits</h3>
                                    <a href="shop.html" class="btn-main btn-small">Shop Now</a>
                                </div>
                                <div class="shop-section__item white-bg wow animate__animated animate__fadeInUp" data-wow-delay="0.1s">
                                    <img src="img/shop-section-img-2.jpg" alt="background">
                                    <h3>Stethoscopes</h3>
                                    <p>A wide range of stethoscopes from most famous and trusted brands</p>
                                    <a href="shop.html" class="btn-main btn-small">Shop Now</a>
                                </div>
                            </div>

                            <div class="shop-section__row">
                                <div class="shop-section__item wow animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                                    <img src="img/shop-section-img-3.jpg" alt="background">
                                    <h3>Nitrile <br>Examination <br>Gloves</h3>
                                    <a href="shop.html" class="btn-main btn-small">Shop Now</a>
                                </div>
                                <div class="shop-section__item wow animate__animated animate__fadeInUp" data-wow-delay="0.4s">
                                    <img src="img/shop-section-img-4.jpg" alt="background">
                                    <h3>Blood Pressure<br> Monitors</h3>
                                    <a href="shop.html" class="btn-main btn-small">Shop Now</a>
                                </div>
                            </div>-->

                        </div>
                    </div>
                </div>
            </div>

        </section>

        <section class="achievements">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="achievements__wrap">

                            <?php
                                $repeater= $achievements;
                                if ( is_array($repeater) && count($repeater) )
                                {
                                    $delay=0;
                                    foreach ($repeater as $key => $item)
                                    {
                                        $im = get_image($item['icon'],'',1);

                                        echo "
                                        <div class=\"achievements__item wow animate__animated animate__zoomIn\" data-wow-delay=\"{$delay}s\">
                                           $im
                                            <h4>$item[title]</h4>
                                        </div>";
                                        $delay+=0.2;
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
                        <h2><?php echo $brands['title'];?></h2>
                        <!-- Slider main container -->
                        <div class="swiper swiper-logo">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <?php
                                    $repeater= $brands['brands_list'];
                                    if ( is_array($repeater) && count($repeater) )
                                    {
                                       foreach ($repeater as $key => $item)
                                       {
                                           $im=get_image($item['image'],'',1);
                                            echo "
                                                <div class=\"swiper-slide slide__logo\">
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
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>]  -->
<?php
get_footer();
?>