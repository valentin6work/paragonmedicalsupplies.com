<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<?php
    if (is_shop()){
    $shop_page_id = wc_get_page_id( 'shop' );
?>
        <!-- is_shop() -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="banner-section__wrap">
                <div class="breadcrumbs">
                    <?php
                        if (function_exists('bcn_display')) {
                            bcn_display();
                        }
                    ?>
                </div>
                <h1>
                    <?php
                        echo get_the_title( $shop_page_id );
                    ?>
                </h1>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php
    if (is_tax('product_cat'))
    {
        $term = get_queried_object();
    ?>
        <!-- is_tax('product_cat') -->
        <div class="container" >
            <div class="row">
                <div class="col-12">
                    <div class="banner-section__wrap">
                        <div class="breadcrumbs">
                            <?php
                            if (function_exists('bcn_display')) {
                                bcn_display();
                            }
                            ?>
                        </div>
                        <h1>
                            <?php
                                echo $term->name;
                            ?>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
?>

<?php
    if (is_product())
    {
        ?>
<nav class="woocommerce-breadcrumb">
        <?php
        if (function_exists('bcn_display')) {
            bcn_display();
        }
        ?>
</nav>
<?php
    }
?>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->