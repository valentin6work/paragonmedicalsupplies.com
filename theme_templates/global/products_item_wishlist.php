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

<div class="product">
    <div class="product__properties">
        <?php echo $product_badge_html; ?>
        <div class="product__action">
            <div class="product__comparison active" data-prod_id="<?php echo get_query_var('product_id');?>" >
                <img src="<?php echo theme_url;?>/img/comparison.svg" alt="icon">
            </div>
            <div class="product__remove-icon" data-prod_id="<?php echo get_query_var('product_id');?>" >
                <img src="<?php echo theme_url;?>/img/close-wishlist.svg" alt="close">
            </div>
        </div>
    </div>
    <a href="#" class="woocommerce-Loop woocommerce-loop-product__link">
        <div class="product-image">
            <img class="woocommerce-placeholder wp-post-image" src="<?php echo $product_image; ?>" alt="image">
        </div>
        <div class="woocommerce-loop-product__title"><?php echo get_the_title(get_query_var('product_id')); ?></div>
    </a>
    <div class="description__block">
        <p><?php echo $product->get_short_description(); ?></p>
    </div>
    <span class="price">
        <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol"><?php echo get_woocommerce_currency_symbol(); ?></span>&nbsp;<?php echo $price; ?></bdi></span>
    </span>
    <div class="wp-block-button product-add-to-cart">
        <a href="<?php echo $add_to_cart_url; ?>" class="button product_type_simple add_to_cart_button ajax_add_to_cart"><img src="<?php echo theme_url; ?>/img/cart-white.svg" alt="cart"><span>Add to Cart</span></a>
    </div>
</div>

<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->