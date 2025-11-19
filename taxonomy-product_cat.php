<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<?php
get_header();
$shop_page_id = wc_get_page_id( 'shop' );
$background = get_field('background',$shop_page_id);

$term = get_queried_object();
$background_category = get_field('background',$term);

$background_out = $background_category?$background_category:$background;

$current_category = get_queried_object();
$category_id = $current_category->term_id;

?>
<script>
    const category_id = parseInt('<?php echo $category_id;?>');
</script>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<div class="wrapper">
    <main class="page">
        <section class="banner__section" style="background-image: url(<?php echo $background_out['url'];?>)">
            <?php
                get_template_part( 'theme_templates/global/breadcrumbs_shop');
            ?>
        </section>

        <!-- content -->
        <section class="products-filter">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="products-filter__wrap">
                            <div class="sort-wrap">

                                <!-- filter__selection -->
                                <div class="filter__selection">
                                    <div class="filter__row" id="selected_filters" >

                                    </div>
                                </div>
                                <!-- /filter__selection -->

                                <!-- sorting -->

                                    <select id="filter_sorted" name="orderby" class="orderby products-sort-select js-example-basic-single" aria-label="Shop order">
                                        <option value="menu_order">Default sorting</option>
                                        <option value="popularity">Sort by popularity</option>
                                        <option value="rating">Sort by average rating</option>
                                        <option value="date">Sort by latest</option>
                                        <option value="price" selected="selected">Sort by price: low to high</option>
                                        <option value="price-desc">Sort by price: high to low</option>
                                    </select>
                                    <input type="hidden" name="paged" value="1">

                                <!-- /sorting -->
                                <div class="filter-category__button" aria-expanded="false" aria-controls="filter-products-block">
                                    Filters
                                </div>
                            </div>
                            <div class="filter-products__wrap">
                                <!-- product filter form -->
                                <div class="filter-products-block">
                                    <div class="category__info-block">
                                        <div class="filter-close-btn"><img src="<?php echo theme_url;?>/img/close_filter_cell.svg" alt="close"></div>
                                        <h3>Filters</h3>
                                        <div class="filter-block-item">
                                            <h4>Type</h4>

                                            <ul class="sidebar-widget filter__type">
                                                <?php
                                                $terms = get_terms(array(
                                                    'taxonomy' => 'prod_type',
                                                    'hide_empty' => false,
                                                ));

                                                if (!is_wp_error($terms) && !empty($terms)) {
                                                    foreach ($terms as $term) {
                                                        $count = get_product_count_in_term($term->term_id,'prod_type',$category_id);
                                                        echo "<li><a class='filter_item' href=\"#\" data-term_name='$term->name' data-term_id='$term->term_id' data-tax='prod_type' >$term->name </a><span class=\"filters__quantity\">$count</span></li>";
                                                    }
                                                }
                                                ?>
                                            </ul>
                                            <button id="filterShowMoreType" data-state="hidetype" >More..</button>
                                        </div>
                                        <div class="filter-block-item">
                                            <h4>Brand</h4>
                                            <ul class="sidebar-widget filter__brand">
                                                <?php
                                                $terms = get_terms(array(
                                                    'taxonomy' => 'brand',
                                                    'hide_empty' => false,
                                                ));

                                                if (!is_wp_error($terms) && !empty($terms)) {
                                                    foreach ($terms as $term) {
                                                        $count = get_product_count_in_term($term->term_id,'brand',$category_id);
                                                        echo "<li><a class='filter_item' href=\"#\" data-term_name='$term->name' data-term_id='$term->term_id' data-tax='brand' >$term->name </a><span class=\"filters__quantity\">$count</span></li>";
                                                    }
                                                }
                                                ?>
                                            </ul>
                                            <button id="filterShowMore" data-state="hideBrands">More..</button>
                                        </div>
                                        <div class="filter-block-item">
                                            <h4>Price</h4>
                                            <?php

                                                $range = get_min_max_price_by_category_id($category_id);
                                            ?>
                                            <div class="sidebar-widget filer__price">
                                                <div class="price-filter">
                                                    <div class="price-inputs">
                                                        <input type="text" id="min-price" class="dollar-input" placeholder="Min" value="<?php echo $range['min'];?>" min="<?php echo $range['min'];?>" max="<?php echo $range['max'];?>" >
                                                        <span>-</span>
                                                        <input type="text" id="max-price" class="dollar-input" placeholder="Max" value="<?php echo $range['max'];?>" min="<?php echo $range['min'];?>" max="<?php echo $range['max'];?>" >
                                                    </div>
                                                    <input type="text" id="rangeSlider">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="filter-block-item">
                                            <h4>Special Interests</h4>
                                            <ul class="sidebar-widget filter__interests">
                                                <?php
                                                $terms = get_terms(array(
                                                    'taxonomy' => 'special_interests',
                                                    'hide_empty' => false,
                                                ));

                                                if (!is_wp_error($terms) && !empty($terms)) {
                                                    foreach ($terms as $term) {
                                                        $count = get_product_count_in_term($term->term_id,'special_interests',$category_id);
                                                        echo "<li><a class='filter_item' href=\"#\" data-term_name='$term->name' data-term_id='$term->term_id' data-tax='special_interests'  >$term->name </a><span class=\"filters__quantity\">$count</span></li>";
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- /product filter form -->

                                <div class="products__wrap woocommerce">
                                    <div class="products description-text__wrap" id="prod_list">
                                        <!-- products list -->
                                        <?php
                                           echo $woocomerce_product->get_product()['html'];
                                        ?>
                                        <!-- /products list -->

                                    </div>
                                    <!-- paginator -->
                                    <nav id="filt_pagin" class="pagination woocommerce-pagination wd-pagination">
                                        <?php
                                            echo $woocomerce_product->get_product()['pag'];
                                        ?>
                                    </nav>
                                    <!-- /paginator -->
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /content -->

        <?php
            get_template_part( 'theme_templates/global/contacts');
        ?>
    </main>
</div>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  ]-->
<?php
get_footer();
?>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->