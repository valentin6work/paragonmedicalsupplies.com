<?php
/**
 * Template Name: Search page
 *
 *
 */
get_header();

$contact_info = get_field('contact_info',get_the_ID());
$form_data = get_field('form_data',get_the_ID());

$current_category = get_queried_object();
$category_id = $current_category->term_id;

$us = isset($_GET['search_word'])?sanitize_text_field($_GET['search_word']):'';

?>
    <script>
        const category_id = parseInt('<?php echo $category_id?$category_id:0;?>');
    </script>

<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<div class="wrapper">
    <main class="page">
        <section class="banner__section" style="background-image: url(<?php echo theme_url;?>/img/shop-banner-bg.jpg)">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="banner-section__wrap">
                            <?php
                                get_template_part( 'theme_templates/global/breadcrumbs_shop');
                            ?>
                            <h1>Search results: <span id="swd"><?php echo $us;?></span></h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="products-filter">
            <div class="container">
                <div class="row">
                    <div class="col-12">

                        <div class="search-container">
                            <input type="text" id="search_w" class="search-input" placeholder="Search..." value="<?php echo $us;?>" >
                            <button class="search-button" id="searxh" ><img src="<?php echo theme_url;?>/img/search-white.svg" alt="search"></button>
                        </div>

                        <div class="products-filter__wrap">
                            <div class="sort-wrap">

                                <div class="filter__selection">
                                    <div class="filter__row" id="selected_filters" >

                                    </div>
                                </div>



                                <form class="woocommerce-ordering" method="get">
                                    <select id="mySelect" class=" js-example-basic-single" aria-label="Shop order">
                                        <option value="menu_order">Default sorting</option>
                                        <option value="popularity">Sort by popularity</option>
                                        <option value="rating">Sort by average rating</option>
                                        <option value="date">Sort by latest</option>
                                        <option value="price" selected="selected">Sort by price: low to high</option>
                                        <option value="price-desc">Sort by price: high to low</option>
                                    </select>
                                    <input type="hidden" name="paged" value="1">
                                </form>
                                <div class="filter-category__button" aria-expanded="false" aria-controls="filter-products-block">
                                    Filters
                                </div>
                            </div>
                            <div class="filter-products__wrap">
                                <div class="filter-products-block">

                                    <div class="category__info-block">
                                        <div class="filter-close-btn"><img src="img/close_filter_cell.svg" alt="close"></div>
                                        <h3>Filters</h3>

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
                                <div class="products__wrap woocommerce">
                                    <div class="products description-text__wrap" id="prod_list">
                                        <!-- products list -->
                                        <?php
                                            echo $woocomerce_product->get_product()['html'];
                                        ?>
                                        <!-- /products list -->
                                    </div>

                                    <nav id="filt_pagin" class="pagination woocommerce-pagination wd-pagination">
                                        <?php
                                            echo $woocomerce_product->get_product()['pag'];
                                        ?>
                                    </nav>
                                </div>

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