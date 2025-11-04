<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->

<nav class="woocommerce-breadcrumb">
    <?php
        if (function_exists('bcn_display')) {
            bcn_display();
        }
    ?>
</nav>

<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->