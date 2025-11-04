<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <nav class="woocommerce-breadcrumb">
                <?php
                    if (function_exists('bcn_display')) {
                        bcn_display();
                    }
                ?>
            </nav>
        </div>
    </div>
</div>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->