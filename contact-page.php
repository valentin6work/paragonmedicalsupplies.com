<?php
/**
 * Template Name: Contact page
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
        <section class="contact-page__section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <div class="contacts__data-wrap">

                            <?php
                                get_template_part( 'theme_templates/global/breadcrumbs_page');
                            ?>

                            <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0s">
                                <?php
                                    echo $contact_info['title'];
                                ?>
                            </h2>
                            <div class="contacts-data-item__wrap">
                                <ul class="contacts-data__list">
                                    <?php
                                    $repeater= $contact_info['contacts_data'];
                                    if ( is_array($repeater) && count($repeater) )
                                    {
                                        $delay=0.1;
                                        foreach ($repeater as $key => $item)
                                        {
                                            $icon=get_image($item['icon'],'',1);
                                            $link=$item['link'];
                                            if ($link) {
                                                $text_out = "
                                                 <a href=\"$link[url]\" target='$link[target]'>
                                                     $item[text]
                                                 </a>
                                            ";
                                            }
                                            else
                                            {
                                                $text_out = "
                                                     $item[text]
                                            ";
                                            }

                                            echo "
                                             <li class=\"wow animate__animated animate__fadeInUp\" data-wow-delay=\"{$delay}s\">
                                            $icon
                                            $text_out
                                             </li>";
                                            $delay+=0.1;
                                        }
                                    }
                                    ?>

                                    <li class="wow animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                                        <?php
                                            echo get_image($contact_info['contact_social_icon'],'',1);
                                        ?>
                                        <div class="contacts__soc-links">
                                            <?php
                                            $repeater= $contact_info['contacts_social'];
                                            if ( is_array($repeater) && count($repeater) )
                                            {
                                                foreach ($repeater as $key => $item)
                                                {
                                                    $icon=get_image($item['icon'],'',1);
                                                    $link=$item['link'];
                                                    echo "
                                                        <a href=\"$link[url]\" target='$link[target]'>$icon</a>
                                                    ";
                                                }
                                            }
                                            ?>


                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-7">
                        <div class="contacts__form">
                            <div class="contacts-form__wrap white-bg">
                                <h3>Send Us a Message</h3>
                                <form class="contact__form form__input-style" action="#" method="post">
                                    <div class="company-info__input-wrapper">
                                        <div class="form__input">
                                            <label for="firstName">First Name<span class="red__star">*</span></label>
                                            <input type="text" name="firstName" id="firstName" placeholder="" required>
                                        </div>
                                        <div class="form__input">
                                            <label for="lastName">Last Name<span class="red__star">*</span></label>
                                            <input type="text" name="lastName" id="lastName" placeholder="" required>
                                        </div>
                                        <div class="form__input">
                                            <label for="contactEmail">Email<span class="red__star">*</span></label>
                                            <input type="email" name="contactEmail" id="contactEmail" placeholder="" required>
                                        </div>
                                        <div class="form__input">
                                            <label for="contactPhone">Phone</label>
                                            <input type="tel"name="contactPhone" id="contactPhone" placeholder="">
                                        </div>
                                        <div class="form__input form__input-full-width">
                                            <label for="contactSubject">Subject</label>
                                            <select id="contactSubject" class="js-example-basic-single">
                                                <option value="" selected>Select subject</option>
                                                <?php
                                                $repeater= $form_data['subject_list'];
                                                if ( is_array($repeater) && count($repeater) )
                                                {
                                                    foreach ($repeater as $key => $item)
                                                    {
                                                        echo "<option value=\"$item[title]\">$item[title]</option>\n";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form__input form__input-full-width">
                                            <label for="contactMessage">Your Message</label>
                                            <textarea name="contactMessage" id="contactMessage" cols="50" rows="4" placeholder=""></textarea>
                                        </div>
                                        <button type="submit" class="btn-main btn-large btn-border">Send Message</button>
                                    </div>
                                </form>
                                <div class="form__error"></div>
                                <div class="form__success"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>]  -->
<?php
get_footer();
?>