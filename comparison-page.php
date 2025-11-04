<?php
/**
 * Template Name: Comparison page
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
            <section class="banner__section" style="background-image: url(<?php echo theme_url;?>/img/shop-banner-bg.jpg)">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="banner-section__wrap">
                                <?php
                                    get_template_part( 'theme_templates/global/breadcrumbs_page');
                                ?>

                                <h1><?php the_title();?> </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="product-comparison__section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="product-comparison__wrap">

                                <div class="product-comparison__container-wrapper">
                                    <button class="slider-button prev-sl disabled" aria-label="Previous"></button>
                                    <button class="slider-button next-sl" aria-label="Next"></button>
                                </div>


                                <div class="product-comp__checkbox-row">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" name="checkBox" id="only_diff">
                                        <label for="checkBox">Only show differences</label>
                                    </div>
                                    <a href="<?php echo  get_permalink(wc_get_page_id('shop'));?>" class="btn-add-product btn-main btn-small btn-border another_product ">Add another product</a>
                                </div>

                                <div class="product-comparison__container scroll-block__styles" id="compare_content" >

                                </div>

                                <a href="#productComparison" class="scroll-btn"></a>

                            </div>
                        </div>
                    </div>
                </div>


            </section>


            <?php
            get_template_part( 'theme_templates/global/contacts');
            ?>
        </main>
    </div>

<script>
    jQuery(document).ready(function(){

        let prevButton = $('.slider-button.prev-sl');
        let nextButton = $('.slider-button.next-sl');
        let rows = $('.product-comparison__row');
        let container = $('.product-comparison__container-wrapper');
        let currentIndex = 0;
        let itemsToShow = 2;
        let itemWidth = 100 / itemsToShow;
        let isMobile = window.innerWidth <= 767;


        let compare = JSON.parse(localStorage.getItem('prod_compare')) || [];


        if (compare.length==4)
        {
            $('.another_product').hide();
        }
        else
        {
            $('.another_product').show();
        }

        if (compare.length)
        {
            $.post(ajaxurl.url, {
                action: 'comparison',
                compare_list: compare
            }).done(function(response) {
              let obj= JSON.parse(response);
              $('#compare_content').html(obj.prod_head_html);

                rows = $('.product-comparison__row');
                updateSlider();
            }).fail(function() {

            });
        }
        else
        {
            $('.product-comparison__container-wrapper').hide();
            $('#compare_content').html('<p>Products comparison list is empty</p>');
        }



        $('#only_diff').on('change', function() {
            if (this.checked) {
                $('.product-comparison__row').each(function() {
                    let contentMap = {};
                    let duplicates = [];

                    $(this).find('.product-comparison__col').each(function() {
                        let content = $(this).html().trim();

                        if (contentMap[content]) {
                            duplicates.push(content);
                        } else {
                            contentMap[content] = true;
                        }
                    });
                    if (duplicates.length > 0) {
                        $(this).find('.product-comparison__col').each(function() {
                            let content = $(this).html().trim();
                            if (duplicates.includes(content)) {
                                $(this).hide();
                            }
                        });
                    }
                });
            } else {
                $('.product-comparison__col').show();
            }
        });




//----------------------------------------------------

        /*let prevButton = $('.slider-button.prev-sl');
        let nextButton = $('.slider-button.next-sl');
        let rows = $('.product-comparison__row');
        let container = $('.product-comparison__container-wrapper');
        let currentIndex = 0;
        let itemsToShow = 2;
        let itemWidth = 100 / itemsToShow;
        let isMobile = window.innerWidth <= 767;*/


        function updateSlider() {
            if (!isMobile) {
                resetSlider();
                return;
            }
            const totalItems = compare.length;
            rows.each(function() {
                const row = $(this);
                //const totalItems = row.children().length;
                const maxIndex = totalItems - itemsToShow;
                const translateX = -(currentIndex * itemWidth);

                if (currentIndex <= maxIndex && currentIndex >= 0) {
                    row.css('transform', `translateX(${translateX}%`);
                }
            });

            updateButtonStates();
           // updateContainerVisibility();
        }

        function resetSlider() {
            rows.css('transform', 'none');
            prevButton.removeClass('disabled');
            nextButton.removeClass('disabled');
            currentIndex = 0;
        }

        function updateButtonStates() {
            if (!isMobile) return;

            const maxIndex = Math.max(...rows.map(function() {
                return $(this).children().length - itemsToShow;
            }).get());

            prevButton.toggleClass('disabled', currentIndex <= 0);
            nextButton.toggleClass('disabled', currentIndex >= maxIndex);

           /* if ( currentIndex <= 0 && currentIndex >= maxIndex )
            {
                $('.product-comparison__container-wrapper').toggle();
            }*/

            if (compare.length<3)
            {
                $('.product-comparison__container-wrapper').hide();
            }
            else
            {
                $('.product-comparison__container-wrapper').show();
            }
        }

        function updateContainerVisibility() {
            if (!isMobile) return;

            $('.product-comparison__container .product-comparison__row:not(.parameter__row)').each(function() {
                const row = $(this);
                const columnsCount = row.find('.product-comparison__col').length;


                /*$('.product-comparison__container-wrapper')
                    .toggle(columnsCount > 2);*/
            });
        }

        nextButton.on('click', function() {
            if (!isMobile) return;

            const maxIndex = Math.max(...rows.map(function() {
                return $(this).children().length - itemsToShow;
            }).get());

            if (currentIndex < maxIndex) {
                currentIndex++;
                updateSlider();
            }
        });

        prevButton.on('click', function() {
            if (!isMobile) return;

            if (currentIndex > 0) {
                currentIndex--;
                updateSlider();
            }
        });

        $(window).on('resize', function() {
            isMobile = window.innerWidth <= 767;
            if (rows.length)  {
                updateSlider();
            }
        });

        /*if (rows.length)  {
            updateSlider();
        }*/

    });
</script>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>]  -->
<?php
get_footer();
?>