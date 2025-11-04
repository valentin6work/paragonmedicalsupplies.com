<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<?php
$product = wc_get_product(get_query_var('product_id'));
$price = $product->get_price();
$product_image = wp_get_attachment_image_url($product->get_image_id(), 'full');
$product_image = $product_image?$product_image : wc_placeholder_img_src();

$product_badge = get_field('product_badge', get_query_var('product_id'));

if ($product->is_type('variable')) {
    $available_variations = $product->get_available_variations();
    $variation = $available_variations[0];
    $price = $variation['display_price'];
    $add_to_cart_url = '?add-to-cart=' . $variation['variation_id'];
} else {
    $add_to_cart_url = '?add-to-cart=' . $product->get_id();
}

$product_badge_html = '';
if ($product_badge) {
    $class = $product_badge['type'];
    $product_badge_html = "
        <span class=\"$class status__cart-product\">$product_badge[text]</span>
    ";
}

if (is_user_company())
{
    $price = personal_discount($variation['variation_id'],$price,0)['regular_price'];
}

?>

<div class="swiper-slide">
    <div class="product">
        <div class="product__properties">
            <?php echo $product_badge_html; ?>
            <div class="product__add-wishlist" data-prod_id="<?php echo get_query_var('product_id');?>" >
                <svg width="34.376" height="30.88" viewBox="0 0 34.376 30.88">
                    <defs></defs>
                    <path data-name="Path 3" d="M5.557,19.342A8.976,8.976,0,0,1,3,13.067,9.2,9.2,0,0,1,19.688,7.851a9.2,9.2,0,0,1,16.688,5.214,8.984,8.984,0,0,1-2.795,6.513L19.688,33.668Z" transform="translate(-2.5 -3.5)" stroke="#57606F" stroke-width="1" fill="#FF0000"></path>
                </svg>
            </div>
        </div>
        <a href="<?php echo get_permalink(get_query_var('product_id')); ?>" class="woocommerce-Loop woocommerce-loop-product__link">
            <div class="product-image">
                <img class="woocommerce-placeholder wp-post-image" src="<?php echo $product_image; ?>" alt="image">
            </div>
            <div class="woocommerce-loop-product__title">
                <?php echo get_the_title(get_query_var('product_id')); ?>
            </div>
        </a>

        <div class="description__block">
            <p><?php echo $product->get_short_description(); ?></p>
        </div>

        <button class="toggle-btn">...</button>
        <div class="description-gap"></div>

        <span class="price">
            <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol"><?php echo get_woocommerce_currency_symbol(); ?></span>&nbsp;<?php echo $price; ?></bdi></span>
        </span>
        <div class="wp-block-button product-add-to-cart">
            <a href="<?php echo $add_to_cart_url; ?>" class="button product_type_simple add_to_cart_button ajax_add_to_cart"><img src="<?php echo theme_url; ?>/img/cart-white.svg" alt="cart"><span>Add to Cart</span></a>
        </div>
    </div>
</div>


<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->