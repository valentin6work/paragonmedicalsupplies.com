<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<?php
    $front_page_id = get_option( 'page_on_front' );
?>
<section class="contacts">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="contacts__wrap">
                    <div class="contacts__data-wrap">
                        <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0s">
                            <?php echo get_field('contact_title',$front_page_id);?>
                        </h2>
                        <div class="contacts-data-item__wrap">
                            <ul class="contacts-data__list">
                                <?php
                                $repeater= get_field('footer_contacts',$front_page_id);
                                if ( is_array($repeater) && count($repeater) )
                                {
                                    foreach ($repeater as $key => $item)
                                    {
                                        $im=get_image($item['icon'],'',1);
                                        $item['title']=nl2br($item['title']);
                                        switch ((int)$item['type'])
                                        {
                                            case 1:
                                                echo " <li class=\"wow animate__animated animate__fadeInUp\" >$im<a href=\"$item[value]\">$item[title]</a></li>";
                                                break;
                                            case 2:
                                                echo " <li class=\"wow animate__animated animate__fadeInUp\" >$im<a href=\"tel:$item[value]\">$item[title]</a></li>";
                                                break;
                                            case 3:
                                                echo " <li class=\"wow animate__animated animate__fadeInUp\" >$im<a href=\"mailto:$item[value]\">$item[title]</a></li>";
                                                break;
                                            case 4:
                                                echo " <li class=\"wow animate__animated animate__fadeInUp\" >$im<a href=\"tel:$item[value]\">$item[title]</a></li>";
                                                break;
                                            case 5:
                                                echo " <li class=\"wow animate__animated animate__fadeInUp\" >$im $item[value]</li>";
                                                break;
                                            default:

                                        }
                                    }
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                    <div class="contact__map">
                        <div class="map_screen">
                            <img src="<?php echo theme_url;?>/img/map_screen.jpg" alt="map">
                        </div>
                        <div id="map" hidden>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  ]-->