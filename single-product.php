<?php
    get_header();

    $post_id = get_the_ID();
    $product = wc_get_product($post_id);
    $currency_symbol = get_woocommerce_currency_symbol();

    $sku = $product->get_sku();
    $description =  $product->get_description() ? $product->get_description() : $product->get_short_description();
    $stock_status = $product->is_in_stock() ? 'In Stock' : 'Out of Stock';
    $stock_class = $product->is_in_stock() ? 'instock' : 'outofstock';

    $main_image_id = $product->get_image_id();
    $main_image_url = $main_image_id ? wp_get_attachment_url($main_image_id) : wc_placeholder_img_src();

    $gallery_image_ids = $product->get_gallery_image_ids();

    $images=[$main_image_url];

    if ( is_array($gallery_image_ids) && count($gallery_image_ids) )
    {
        foreach($gallery_image_ids as $key=>$gallery_image_id)
        {
            $gallery_image_url = wp_get_attachment_url($gallery_image_id);
            $images[]=$gallery_image_url;
        }
    }

    $product_badge = get_field('product_badge', get_query_var('product_id'));
    $product_badge_html = '';
    if ($product_badge) {
        $class = $product_badge['type'];
        $product_badge_html = "
            <span class=\"$class status__cart-product\">$product_badge[text]</span>
        ";
    }




?>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<div class="wrapper">
    <main class="page">
        <section class="product-page__main-section">
            <div class="container">
                <div class="row">
                    <div class="col-12">

                        <?php
                        get_template_part( 'theme_templates/global/breadcrumbs_shop');
                        ?>

                        <div class="product-block__wrap">
                            <div class="product">
                                <div class="woocommerce-product-gallery">
                                    <div class="woocommerce-product-gallery__wrapper">
                                        <div class="slider__flex">
                                            <div class="swiper swiper-thumbs">
                                                <div class="swiper-wrapper">
                                                    <?php
                                                        if ( is_array($images) && count($images) )
                                                        {
                                                            foreach($images as $key=>$url)
                                                            {
                                                               echo "
                                                                    <div class=\"swiper-slide\">
                                                            <div
                                                                    class=\"slider__image woocommerce-product-gallery__image--placeholder\">
                                                                <img src=\"$url\" alt=\"product image\"
                                                                     class=\"wp-post-image\">
                                                            </div>
                                                        </div>
                                                               ";
                                                            }
                                                        }
                                                    ?>

                                                </div>
                                            </div>
                                            <div class="swiper swiper-images">
                                                <div class="swiper-wrapper">
                                                    <?php
                                                    if ( is_array($images) && count($images) )
                                                    {
                                                        foreach($images as $key=>$url)
                                                        {
                                                            echo "
                                                                    <div class=\"swiper-slide\">
                                                            <div
                                                                    class=\"slider__image woocommerce-product-gallery__image--placeholder\">
                                                                <img src=\"$url\" alt=\"product image\"
                                                                     class=\"wp-post-image\">
                                                            </div>
                                                        </div>
                                                               ";
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="summary entry-summary">
                                    <h1 class="product_title entry-title">
                                        <?php the_title();?>

                                        <?php echo $product_badge_html; ?>

                                    </h1>
                                    <ul class="product__info">
                                        <li class="product__id">SKU: <?php echo esc_html($sku); ?></li>
                                        <li class="product__description"><?php echo $description; ?></li>
                                        <li class="product__status <?php echo esc_attr($stock_class); ?>"><?php echo esc_html($stock_status); ?></li>
                                    </ul>

                                    <div class="product-page__price">
                                        <p class="price">
                                            <?php
                                                if ($product->is_type('variable'))
                                                {
                                                    $attribute_name = 'basic-price';

                                                    $variations = $product->get_available_variations();
                                                    $found_variation = null;

                                                    foreach ($variations as $variation) {
                                                        $variation_obj = new WC_Product_Variation($variation['variation_id']);
                                                        $attributes = $variation_obj->get_attributes();

                                                        if ( $attributes['pa_count-by']==$attribute_name ) {
                                                            $found_variation = $variation_obj;
                                                            break;
                                                        }
                                                    }

                                                    if ($found_variation) {

                                                        $regular_price = $found_variation->get_regular_price();
                                                        $sale_price = $found_variation->get_sale_price();

                                                        if (is_user_company())
                                                        {
                                                            $regular_price = personal_discount($variation['variation_id'],$regular_price,$sale_price)['regular_price'];
                                                            $sale_price = personal_discount($variation['variation_id'],$regular_price,$sale_price)['sale_price'];
                                                        }

                                                        $currency_symbol = get_woocommerce_currency_symbol();

                                                        if ($sale_price) {
                                                            echo '<span class="woocommerce-Price-amount amount new-price"><bdi><span class="woocommerce-Price-currencySymbol">' . esc_html($currency_symbol) . '</span>&nbsp;' . esc_html($sale_price) . '</bdi></span>';
                                                            echo '<span class="woocommerce-Price-amount amount old-price"><bdi><span class="woocommerce-Price-currencySymbol">' . esc_html($currency_symbol) . '</span>&nbsp;' . esc_html($regular_price) . '</bdi></span>';
                                                        } else {
                                                            echo '<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">' . esc_html($currency_symbol) . '</span>&nbsp;' . esc_html($regular_price) . '</bdi></span>';
                                                        }
                                                    }
                                                }
                                            ?>

                                        </p>
                                        <div class="wholesale-prices__wrap">

                                            <?php
                                            if ( function_exists('get_field') && $product instanceof WC_Product ) {

                                                // Репітер cost_discount можна вішати або на сам продукт, або на батьківський
                                                $product_id = $product->get_id();
                                                $rows       = get_field('cost_discount', $product_id);

                                                if ( ( ! is_array($rows) || empty($rows) ) && $product->is_type('variation') ) {
                                                    $rows = get_field('cost_discount', $product->get_parent_id());
                                                }

                                                if ( is_array($rows) && ! empty($rows) ) {

                                                    // Базова ціна (Basic price) – як ти і хочеш, в інтерфейсі не змінюємо
                                                    $base_price      = floatval( $product->get_price() );
                                                    $currency_symbol = get_woocommerce_currency_symbol();
                                                    $product_cart_id = $product->get_id();

                                                    foreach ( $rows as $row ) {

                                                        $count      = isset($row['count']) ? intval($row['count']) : 0;
                                                        $percentage = isset($row['percentage']) ? floatval($row['percentage']) : 0;

                                                        if ( $count <= 0 || $percentage <= 0 ) {
                                                            continue;
                                                        }

                                                        // Ціна з урахуванням знижки з репітера
                                                        $regular_price = $base_price * ( 1 - $percentage / 100 );
                                                        $sale_price    = '';

                                                        // Персональна знижка для компаній – залишаю твою логіку
                                                        if ( function_exists('is_user_company') && is_user_company() && function_exists('personal_discount') ) {
                                                            $pd            = personal_discount( $product_cart_id, $regular_price, $sale_price );
                                                            $regular_price = isset($pd['regular_price']) ? $pd['regular_price'] : $regular_price;
                                                            $sale_price    = isset($pd['sale_price']) ? $pd['sale_price'] : $sale_price;
                                                        }

                                                        // Те, що показуємо як назву – тут це кількість (можеш поміняти під свій текст)
                                                        $display_value = $count . ' boxes';
                                                        // Опис – відсоток знижки
                                                        $description   = $percentage . '% off';

                                                        // URL для додавання в корзину з потрібною кількістю
                                                        $add_to_cart_url = esc_url( add_query_arg(
                                                            array(
                                                                'add-to-cart' => $product_cart_id,
                                                                'quantity'    => $count,
                                                            ),
                                                            wc_get_cart_url()
                                                        ) );

                                                        $regular_price_html = wc_format_decimal( $regular_price, wc_get_price_decimals() );

                                                        echo "
             <div class=\"wholesale-prices__item\"
                  data-url=\"{$add_to_cart_url}\"
                  data-qty=\"{$count}\"
                  data-price=\"{$regular_price_html}\"
                  data-sale=\"{$sale_price}\">
                <p>{$display_value}</p>
                <p class=\"wholesale-prices__price price__10off\">
                    <span>{$currency_symbol}&nbsp;{$regular_price_html}</span>/box</p>
                <p>{$description}</p>
            </div>
            ";
                                                    }
                                                }
                                            }
                                            ?>


                                        </div>
                                    </div>

                                   <form id="product-form" class="cart white-bg" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                                       <input type="hidden" name="product_id" value="<?php echo esc_attr( get_the_ID() ); ?>">
                                       <input type="hidden" name="variation_id" value="<?php echo $found_variation->get_id();?>" id="variation_id">

                                        <div class="quantity">
                                            <div class="wc-block-components-quantity-selector product-page__quantity">
                                                <input id="pcount"
                                                        class="wc-block-components-quantity-selector__input"
                                                        type="number" step="1" min="1"
                                                        max="9999" value="1" name="quantity">
                                                <div class="btn-quant-prod__wrap">
                                                    <button id="fplus" class="wc-block-components-quantity-selector__button wc-block-components-quantity-selector__button--plus"><img src="<?php echo theme_url;?>/img/down-arrow.svg" alt="arrow"></button>
                                                    <button  id="fminus"  class="wc-block-components-quantity-selector__button wc-block-components-quantity-selector__button--minus"><img src="<?php echo theme_url;?>/img/down-arrow.svg" alt="arrow"></button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="add-to-cart"
                                                class="single_add_to_cart_button button alt btn-main">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 20">
                                                <g clip-path="url(#clip0_28_187)">
                                                    <mask id="mask0_28_187" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="21" height="20">
                                                        <path d="M0.5 1.90735e-06H20.5V20H0.5V1.90735e-06Z" fill="white"/>
                                                    </mask>
                                                    <g mask="url(#mask0_28_187)" class="cart-icon">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.44108 13.5803C6.47405 13.8771 6.72487 14.1016 7.02344 14.1016H17.7495C18.6087 14.1016 19.3421 13.4804 19.4834 12.6327L20.492 6.5807C20.5203 6.41081 20.4725 6.23706 20.3611 6.10564C20.2498 5.97422 20.0863 5.89844 19.9141 5.89844H6.76663L6.43715 2.93311C6.41817 1.97872 5.63856 1.21094 4.67969 1.21094H1.08594C0.762333 1.21094 0.5 1.47327 0.5 1.79688C0.5 2.12048 0.762333 2.38281 1.08594 2.38281H4.67969C5.00328 2.38281 5.26562 2.64514 5.26562 2.96875C5.26562 2.99037 5.26682 3.01197 5.26921 3.03346L5.65905 6.54203C5.65956 6.54723 5.66013 6.55241 5.66078 6.55756L6.44108 13.5803ZM6.89683 7.07031H19.2224L18.3274 12.4401C18.2803 12.7226 18.0359 12.9297 17.7495 12.9297H7.54788L6.89683 7.07031Z"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.26562 14.6875C5.26562 15.6583 6.05266 16.4453 7.02344 16.4453H16.3984C16.722 16.4453 16.9844 16.183 16.9844 15.8594C16.9844 15.5358 16.722 15.2734 16.3984 15.2734H7.02344C6.69984 15.2734 6.4375 15.0111 6.4375 14.6875C6.4375 14.3639 6.69984 14.1016 7.02344 14.1016C7.34704 14.1016 7.60938 13.8392 7.60938 13.5156C7.60938 13.192 7.34704 12.9297 7.02344 12.9297C6.05266 12.9297 5.26562 13.7167 5.26562 14.6875Z"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.60938 17.0312C7.60938 18.0021 8.39641 18.7891 9.36719 18.7891C10.338 18.7891 11.125 18.0021 11.125 17.0312C11.125 16.0604 10.338 15.2734 9.36719 15.2734C8.39641 15.2734 7.60938 16.0604 7.60938 17.0312ZM9.36719 17.6172C9.04359 17.6172 8.78125 17.3549 8.78125 17.0312C8.78125 16.7076 9.04359 16.4453 9.36719 16.4453C9.69078 16.4453 9.95312 16.7076 9.95312 17.0312C9.95312 17.3549 9.69078 17.6172 9.36719 17.6172Z"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.6406 17.0312C14.6406 18.0021 15.4277 18.7891 16.3984 18.7891C17.3692 18.7891 18.1562 18.0021 18.1562 17.0312C18.1562 16.0604 17.3692 15.2734 16.3984 15.2734C15.4277 15.2734 14.6406 16.0604 14.6406 17.0312ZM16.3984 17.6172C16.0748 17.6172 15.8125 17.3549 15.8125 17.0312C15.8125 16.7076 16.0748 16.4453 16.3984 16.4453C16.722 16.4453 16.9844 16.7076 16.9844 17.0312C16.9844 17.3549 16.722 17.6172 16.3984 17.6172Z"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.36719 7.07031C9.69079 7.07031 9.95312 6.80798 9.95312 6.48438V4.72656H12.8828C13.2064 4.72656 13.4688 4.46423 13.4688 4.14062C13.4688 3.81702 13.2064 3.55469 12.8828 3.55469H9.36719C9.04358 3.55469 8.78125 3.81702 8.78125 4.14062V6.48438C8.78125 6.80798 9.04358 7.07031 9.36719 7.07031Z"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8828 7.07031C13.2064 7.07031 13.4687 6.80798 13.4687 6.48438V3.55469H16.9844V6.48438C16.9844 6.80798 17.2467 7.07031 17.5703 7.07031C17.8939 7.07031 18.1562 6.80798 18.1562 6.48438V2.96875C18.1562 2.64515 17.8939 2.38281 17.5703 2.38281H12.8828C12.5592 2.38281 12.2969 2.64515 12.2969 2.96875V6.48438C12.2969 6.80798 12.5592 7.07031 12.8828 7.07031Z"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.36719 11.7578C9.69079 11.7578 9.95312 11.4955 9.95312 11.1719V8.82812C9.95312 8.50452 9.69079 8.24219 9.36719 8.24219C9.04358 8.24219 8.78125 8.50452 8.78125 8.82812V11.1719C8.78125 11.4955 9.04358 11.7578 9.36719 11.7578Z"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8828 11.7578C13.2064 11.7578 13.4687 11.4955 13.4687 11.1719V8.82812C13.4687 8.50452 13.2064 8.24219 12.8828 8.24219C12.5592 8.24219 12.2969 8.50452 12.2969 8.82812V11.1719C12.2969 11.4955 12.5592 11.7578 12.8828 11.7578Z"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.3984 11.7578C16.722 11.7578 16.9844 11.4955 16.9844 11.1719V8.82812C16.9844 8.50452 16.722 8.24219 16.3984 8.24219C16.0748 8.24219 15.8125 8.50452 15.8125 8.82812V11.1719C15.8125 11.4955 16.0748 11.7578 16.3984 11.7578Z"/>
                                                    </g>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_28_187">
                                                        <rect width="20" height="20" fill="white" transform="translate(0.5)"/>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <span>Add to Cart</span></button>
                                    </form>



                                    <div class="product-page__btn-wrap">
                                        <a href="#" class="product-btn-border btn-filter-img" id="compare" data-prod_id="<?php echo $post_id;?>">
                                            <img
                                                    src="<?php echo theme_url;?>/img/compare.svg" alt="icon"><span>compare</span></a>
                                        <button class="product-btn-border product-page__wishlist" data-prod_id="<?php echo $post_id;?>" >
                                            <svg width="15"
                                                                                                       height="14" viewBox="0 0 34.376 30.88">
                                                <defs></defs>
                                                <path data-name="Path 3"
                                                      d="M5.557,19.342A8.976,8.976,0,0,1,3,13.067,9.2,9.2,0,0,1,19.688,7.851a9.2,9.2,0,0,1,16.688,5.214,8.984,8.984,0,0,1-2.795,6.513L19.688,33.668Z"
                                                      transform="translate(-2.5 -3.5)" stroke="#0C89CD"
                                                      stroke-width="2" fill="none"></path>
                                            </svg>
                                            <span>add to favorites</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="woocommerce-tabs wc-tabs-wrapper">
                                    <ul class="tabs wc-tabs product__tabs-list" role="tablist">
                                        <li class="details_tab active" role="tab" data-tab="tab-details">
                                            Details
                                        </li>
                                        <li class="specifications_tab" role="tab" data-tab="tab-specifications">
                                            Specifications
                                        </li>
                                        <li class="alternatives_tab" role="tab" data-tab="tab-alternatives">
                                            Alternatives
                                        </li>
                                    </ul>
                                    <?php
                                        $product_tabs = get_field('product_tabs',get_the_ID());
                                    ?>
                                    <div class=" panel entry-content ">
                                        <div class="product__tab-content" data-tab-content id="tab-details">
                                           <?php echo $product_tabs['details'];?>
                                        </div>
                                        <div class="product__tab-content hidden" data-tab-content
                                             id="tab-specifications">
                                            <?php //echo $product_tabs['specifications'];?>
                                            <?php
                                            $repeater= $product_tabs['specifications_items'];
                                            if ( is_array($repeater) && count($repeater) )
                                            {
                                                foreach ($repeater as $key => $item)
                                                {
                                                    echo "<p><strong>$item[name]:</strong> $item[value]</p>";
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="product__tab-content hidden" data-tab-content
                                             id="tab-alternatives">
                                            <div class="products alternative-prod-wrap description-text__wrap">
                                                <?php
                                                    $repeater= $product_tabs['alternatives'];
                                                    if ( is_array($repeater) && count($repeater) )
                                                    {
                                                       foreach ($repeater as $key => $item)
                                                       {
                                                           set_query_var('product_id',$item['product']->ID);
                                                           ob_start();
                                                           get_template_part( 'theme_templates/global/products_item_shop');
                                                           $prod_html.= ob_get_contents();
                                                           ob_end_clean();
                                                       }

                                                       echo $prod_html;
                                                    }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="more-products">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>More Products</h2>
                        <div class="swiper products-slider description-text__wrap"">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                <?php
                                    $terms = wp_get_post_terms( $product->get_id(), 'product_cat' );
                                    $category_ids = wp_list_pluck( $terms, 'term_id' );

                                    $args = array(
                                        'post_type'     => 'product',
                                        'posts_per_page' => 4,
                                        'post__not_in' => array( $product->get_id() ),
                                        'orderby' => 'date',
                                        'order' => 'DESC',
                                        'tax_query'           => array(
                                            array(
                                                'taxonomy' => 'product_cat',
                                                'field'    => 'term_id',
                                                'terms'    => $category_ids,
                                                'operator' => 'IN',
                                            ),
                                        ),
                                    );

                                    $query = new WP_Query($args);
                                    $posts = $query->posts;


                                    if (is_array($posts) && count($posts))
                                    {
                                        foreach ($posts as $key => $item)
                                        {
                                            set_query_var('product_id', $item->ID);
                                            get_template_part('theme_templates/global/products_item');
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

        <?php
        get_template_part( 'theme_templates/global/contacts');
        ?>
    </main>
</div>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>]  -->
<?php
    get_footer();
?>
