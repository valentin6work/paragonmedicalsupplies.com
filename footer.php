<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->

<?php
    $theme_footer = get_field('footer','options');
    $api_keys = get_field('api_keys','options');
?>

<footer class="footer">

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer__wrapper">
                    <div class="nav-block__shop">

                        <?php
                            $menu_object = wp_get_nav_menu_object(28);
                        ?>

                        <h4><?php echo $menu_object->name;?></h4>
                        <?php
                            wp_nav_menu([
                                'theme_location'  => '',
                                'menu'            => $menu_object->name,
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
                                'items_wrap'      => '<ul class="footer-categories footer-nav-block" >%3$s</ul>',
                                'depth'           => 0,
                                // 'walker'          => new Custom_Walker_Nav_Menu(),
                            ]);
                        ?>

                    </div>
                    <div class="nav-block__company">
                        <?php
                        $menu_object = wp_get_nav_menu_object(29);
                        ?>

                        <h4><?php echo $menu_object->name;?></h4>
                        <?php
                        wp_nav_menu([
                            'theme_location'  => '',
                            'menu'            => $menu_object->name,
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
                            'items_wrap'      => '<ul class="footer-nav footer-nav-block" >%3$s</ul>',
                            'depth'           => 0,
                            // 'walker'          => new Custom_Walker_Nav_Menu(),
                        ]);
                        ?>

                    </div>
                    <div class="nav-block__support">

                        <?php
                        $menu_object = wp_get_nav_menu_object(30);
                        ?>

                        <h4><?php echo $menu_object->name;?></h4>
                        <?php
                        wp_nav_menu([
                            'theme_location'  => '',
                            'menu'            => $menu_object->name,
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
                            'items_wrap'      => '<ul class="footer-support footer-nav-block" >%3$s</ul>',
                            'depth'           => 0,
                            // 'walker'          => new Custom_Walker_Nav_Menu(),
                        ]);
                        ?>

                    </div>
                    <div class="nav-block__contacts">
                        <h4><?php echo $theme_footer['footer_contacts_title'];?></h4>
                        <ul class="footer-contacts footer-nav-block">
                            <?php
                            $repeater= $theme_footer['footer_contacts'];
                            if ( is_array($repeater) && count($repeater) )
                            {
                                foreach ($repeater as $key => $item)
                                {
                                   switch ((int)$item['type'])
                                   {
                                       case 1:
                                           echo " <li><a href=\"$item[value]\">$item[title]</a></li>";
                                           break;
                                       case 2:
                                           echo " <li><a href=\"tel:$item[value]\">$item[title]</a></li>";
                                           break;
                                       case 3:
                                           echo " <li><a href=\"mailto:$item[value]\">$item[title]</a></li>";
                                           break;
                                       case 4:
                                           echo " <li class=\"whatsapp\" ><a href=\"tel:$item[value]\">$item[title]</a></li>";
                                           break;
                                       default:

                                   }
                                }
                            }
                            ?>

                        </ul>
                        <ul class="footer__soc-link-list">
                            <?php
                                $repeater= $theme_footer['social_link'];
                                if ( is_array($repeater) && count($repeater) )
                                {
                                    foreach ($repeater as $key => $item)
                                    {
                                        $link = $item['link'];
                                        echo "<a href=\"$link[url]\" target='$link[target]' >".get_image($item['icon'],'',1)."</a>";
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                    <div class="newsletter__wrapper">
                        <?php
                            echo do_shortcode('[newsletter_form form="1"]');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer__copyright">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="terms__block">
                        <a class="terms__block__logo" href="<?php echo get_site_url();?>">
                            <?php echo get_image($theme_footer['logo']); ?>
                        </a>
                        <p>©<span class="year"></span> <?php echo $theme_footer['footer_text'];?> <a
                                    href="https://webcapitan.com/">Webcapitan</a>
                        </p>
                        <div class="footer-links__terms">
                            <?php
                            $repeater= $theme_footer['footer_pages'];
                            if ( is_array($repeater) && count($repeater) )
                            {
                                foreach ($repeater as $key => $item)
                                {
                                    $o = $item['post'];
                                    $link = get_permalink($o->ID);
                                    echo "<a href=\"$link\" >$o->post_title</a>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>


<script>
    var $ = jQuery.noConflict();
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js"></script>

<?php wp_footer(); ?>

<script>
    function inet() {

    }
    let map;
    let mapOffice = document.getElementById('map');
    let checker = true;
    let scrpt = document.createElement('script');
    let isStartScript = false;
    scrpt.setAttribute('async', true)
    scrpt.setAttribute('defer', true)
    scrpt.setAttribute('src',
        'https://maps.googleapis.com/maps/api/js?key=<?php echo $api_keys['google_map'];?>&callback=inet&v=weekly'
    )

    function startScript() {
        if (isStartScript == false) {
            document.body.appendChild(scrpt);
            isStartScript = true;
        }
    }

    function initMap() {

        if (document.body.contains(mapOffice) && checker == true) {
            startScript()
            checker = false
            setTimeout(() => {
                const mapScreen = document.querySelector('.map_screen');
                mapScreen.hidden = true;
                mapOffice.hidden = false;
                let mapOfficeCoord = {
                    lat: 36.023065761549525,
                    lng: -80.2782158
                };
                map = new google.maps.Map(document.getElementById("map"), {
                    center: mapOfficeCoord,
                    zoom: 9,
                    styles: stylesLocation,
                    disableDefaultUI: true,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                let markerIconUrl
                if (typeof img !== 'undefined') {
                    markerIconUrl = img.markerIconUrl;
                }
                else {
                    markerIconUrl = `<?php echo theme_url;?>/img/pin_map.svg`;
                }

                new google.maps.Marker({
                    position: {
                        lat: 36.023065761549525,
                        lng: -80.2782158
                    },
                    map,
                    icon: markerIconUrl,
                });

            }, 1000);

        }
    }
    $(document).on('scroll', (e) => {
        initMap();
    })
    if (document.body.classList.contains('contact-page')) {
        window.onload = function() {
            initMap();
        };
    }
</script>



<style>
    a[href*="s-sols.com/products/wordpress/accelerator"],
    img[alt="Seraphinite Accelerator"],
    script[seraph-accel-crit] {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        width: 0 !important;
        height: 0 !important;
        position: absolute !important;
        pointer-events: none !important;
    }
</style>

<script>
    (function(){
        var sel = 'a[href*="s-sols.com/products/wordpress/accelerator"]';
        function zap(root){
            (root.querySelectorAll ? root.querySelectorAll(sel) : []).forEach(function(n){
                if (n && n.parentNode) n.parentNode.removeChild(n);
            });
        }

        if (document.documentElement) zap(document);

        var mo = new MutationObserver(function(list){
            for (var m of list){
                for (var node of m.addedNodes){
                    if (node.nodeType !== 1) continue;
                    if (node.matches && node.matches(sel)) {
                        node.remove();
                        continue;
                    }
                    if (node.querySelector) zap(node);
                }
            }
        });
        mo.observe(document.documentElement, {childList:true, subtree:true});

        document.addEventListener('readystatechange', function(){
            if (document.readyState === 'interactive') zap(document);
        });
    })();
</script>


</body>
</html>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>]  -->