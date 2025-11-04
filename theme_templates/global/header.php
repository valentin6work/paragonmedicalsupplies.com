<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<?php
    global $template;
    $setting = get_field('header','options');
?>


<header class="header header_mobile">
    <div class="header-top-block">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="header-top-block__wrap header-container">
                        <div class="header-top-like header-top-styles"><?php echo $setting['top_title'];?></div>
                        <a href="tel:<?php echo $setting['top_telefon'];?>" class="header-top-tel header-top-styles"><?php echo $setting['top_telefone_text'];?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        if ( basename($template)!='new_password.php' ) {
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="header-nav__wrap header-container">
                    <nav class="menu">
                        <div class="header__burger align-self-center">
                            <span></span>
                        </div>

                        <?php
                            wp_nav_menu([
                                'theme_location'  => '',
                                'menu'            => 'Top menu',
                                'container'       => '<ul>',
                                'container_class' => '',
                                'container_id'    => '',
                                'menu_class'      => '',
                                'menu_id'         => '',
                                'echo'            => true,
                                'fallback_cb'     => '',
                                'before'          => '',
                                'after'           => '',
                                'link_before'     => '',
                                'link_after'      => '',
                                'items_wrap'      => '<ul class="header__item-menu" >%3$s</ul>',
                                'depth'           => 0,
                                //'walker'          => new Custom_Menu_Walker(),
                            ]);
                        ?>

                    </nav>
                    <a href="<?php echo get_site_url();?>" class="header__logo align-self-center">
                        <?php echo get_image($setting['logo'],''); ?>
                    </a>
                    <ul class="header__links">
                        <li><a href="<?php echo get_permalink(380);?>"><img src="<?php echo theme_url;?>/img/search.svg" alt="search"></a></li>
                        <li class="favorites-header" >
                            <a href="<?php echo get_permalink(373);?>">
                                <img src="<?php echo theme_url;?>/img/wishlist.svg" alt="favorite">
                                <span class="wishlist__quantity"><span>0</span></span>
                            </a>
                        </li>

                        <?php
                            if (is_user_logged_in())
                            {
                                $account_url = wc_get_account_endpoint_url('dashboard');
                            }
                            else
                            {
                                $account_url=get_permalink(320);
                            }
                         ?>

                        <li><a href="<?php echo $account_url;?>"><img src="<?php echo theme_url;?>/img/login.svg" alt="user"></a></li>
                        <?php
                            $cart_count = WC()->cart->get_cart_contents_count();
                            $cart_url = wc_get_cart_url();
                        ?>
                        <li class="shopping-cart"><a href="<?php echo $cart_url;?>"><img src="<?php echo theme_url;?>/img/shopping-cart.svg" alt="shopping cart"></a><span class="shopping-cart__quantity">
                                <span><?php echo $cart_count;?></span>
                            </span>
                        </li>
                    </ul>
                    <div class="header-mobile-menu">
                        <?php
                        wp_nav_menu([
                            'theme_location'  => '',
                            'menu'            => 'Top menu',
                            'container'       => '',
                            'container_class' => '',
                            'container_id'    => '',
                            'menu_class'      => '',
                            'menu_id'         => '',
                            'echo'            => true,
                            'fallback_cb'     => '',
                            'before'          => '',
                            'after'           => '',
                            'link_before'     => '',
                            'link_after'      => '',
                            'items_wrap'      => '<ul class="header__item-menu" >%3$s</ul>',
                            'depth'           => 0,
                            //'walker'          => new Custom_Menu_Walker(),
                        ]);
                        ?>
                        <?php
                            display_woocommerce_categories_mobile_menu();
                        ?>
                    </div>
                </div>
                <div class="header__prod-categories header-container">
                    <?php
                        display_woocommerce_categories();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php } ?>
</header>



<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->