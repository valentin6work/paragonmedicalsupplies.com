<?php
/**
 * Template Name: Wishlist page
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
        <section class="banner__section" style="background-image: url(<?php echo theme_url;?>/img/shop-banner-bg.jpg)" >
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="banner-section__wrap">
                            <?php
                                get_template_part( 'theme_templates/global/breadcrumbs');
                            ?>
                            <h1>Favorites</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="wishlist__section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="wishlist__wrap">
                            <div class="sort-wrap">
                                <div class="filter__selection">
                                    <div class="filter__row">
                                        <div class="filter__title-cell filter__title-cell-clear">
                                            <span class="filter__title">Remove All Items</span>
                                            <img src="<?php echo theme_url;?>/img/close_filter_cell.svg" alt="close">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="wishlist__products-wrap filter-products__wrap woocommerce">
                                <div class="products" id="list_wishlist">
                                    <p>Wishlist empty</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
            jQuery(document).ready(function(){
                var storedArray = localStorage.getItem('wishlist');
                storedArray = storedArray ? JSON.parse(storedArray) : [];

                if (storedArray.length)
                {
                    $.ajax({
                        url: ajaxurl.url,
                        type: 'POST',
                        data: { action: 'get_wishlist', storedArray: storedArray },
                        beforeSend: function () {
                            $('#list_wishlist').html('<p>Get wishlist items...</p>');
                        },
                        success: function (response) {
                            let obj;
                            try { obj = typeof response === 'object' ? response : JSON.parse(response); }
                            catch (e) { obj = { prod_html: response }; }
                            $('#list_wishlist').html(obj.prod_html || '');
                        },
                        error: function () {

                        }
                    });

                }
            });
        </script>

        <?php
        get_template_part( 'theme_templates/global/contacts');
        ?>

    </main>
</div>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>]  -->
<?php
get_footer();
?>