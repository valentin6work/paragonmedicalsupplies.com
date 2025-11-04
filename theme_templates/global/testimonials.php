<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<?php
    $front_page_id = get_option( 'page_on_front' );
    $customers_says = get_field('customers_says',$front_page_id);
?>
<section class="testimonials">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2><?php echo $customers_says['title'];?></h2>
                <!-- Slider -->
                <div class="swiper testimonials-slider">

                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">

                        <?php
                        $repeater= $customers_says['items'];
                        if ( is_array($repeater) && count($repeater) )
                        {
                            foreach ($repeater as $key => $item)
                            {
                                $im=get_image($item['author_logo'],'',1);
                                echo "<div class=\"swiper-slide\">
                                                    <div class=\"testimonial__item\">
                                                        <div class=\"star__rating\" data-rating=\"$item[rating]\"></div>
                                                        $item[text]
                                                        <div class=\"author__bottom-block\">
                                                            $im
                                                            <div class=\"authors__data\">
                                                                <div class=\"author__name\">$item[author_name]</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ";
                            }
                        }
                        ?>

                    </div>
                    <div class="swiper-pagination pagination__testimonials pagination__styles"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  ]-->