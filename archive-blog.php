<?php
    get_header();
    $default_view_setting = get_field('default_view_setting','options');
?>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->

    <div class="wrapper">
        <main class="page">

            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php
                            get_template_part( 'theme_templates/global/breadcrumbs');
                        ?>
                    </div>
                </div>
            </div>

            <section class="blog-section blog-post-gap white-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-7 blog_list">
                            <h1><?php
                                if (!is_tax()) {
                                    post_type_archive_title();
                                }
                                else
                                {
                                    single_term_title();
                                }
                                ?></h1>
                            <div class="blog__all-post">
                                <ul class="blog__content-block">
                                    <?php
                                    $args =[
                                        'post_type'      => 'blog',
                                        'paged'          => get_query_var('page')?: 1,
                                        'posts_per_page' => 5,
                                        'orderby'        => 'date',
                                        'order'          => 'ASC',
                                    ];


                                    if (is_tax()) {
                                        $term_id = get_queried_object_id();
                                        $taxonomy = get_queried_object();

                                        $args['tax_query'] = [
                                            [
                                                'taxonomy' => $taxonomy->taxonomy, // Replace with your actual taxonomy name
                                                'field'    => 'id',
                                                'terms'    => $term_id,
                                            ],
                                        ];
                                    }


                                    $query = new WP_Query( $args );
                                    $posts = $query->get_posts();
                                    if (is_array( $posts) && count( $posts))
                                    {
                                        foreach ($posts as $key => $itemp)
                                        {
                                            $link= get_permalink($itemp->ID);

                                            $im_out='';
                                            $image = get_the_post_thumbnail( $itemp->ID, 'blog-thumbnail' );
                                            $image_s = get_image(get_field('small_image',$itemp->ID),'',1);

                                            if ($key<1)
                                            {
                                                if ($image) $im_out=$image;
                                            }
                                            else
                                            {
                                                if ($image_s) $im_out=$image_s;
                                            }

                                            $dateTime = new DateTime($itemp->post_date);
                                            $fdate = $dateTime->format('F j, Y');

                                            $content = wp_trim_words($itemp->post_content, 23, '');

                                            echo "
                                                    <li class=\"blog_item\">
                                                        <a href=\"$link\">
                                                            $im_out
                                                            <div>
                                                                <h5>$itemp->post_title</h5>
                                                                <time datetime=\"$itemp->post_date\">$fdate</time>
                                                                <p> $content</p>
                                                            </div>
                                                        </a>
                                                    </li>";
                                        }
                                    }

                                    ?>
                                </ul>
                                <!-- PAGINATOR -->
                                <nav class="pagination">
                                    <?php
                                    if ($query->max_num_pages > 1)
                                    {
                                        $current_page = max(1, get_query_var('page'));
                                        $total_pages = $query->max_num_pages;


                                        $prev_url = 1;
                                        $prev_url_dis = '';

                                        $next_page = $current_page+1;
                                        $next_page_dis = '';

                                        if ($current_page>$prev_url) {
                                            $prev_url = $current_page - 1;
                                        }

                                        if ($current_page==1)
                                        {
                                            $prev_url_dis = 'disabled';
                                        }

                                        echo "
                                <a class=\"prev page-numbers $prev_url_dis\" href=\"?page=$prev_url\">
                                    <svg width=\"14\" height=\"14\" viewBox=\"0 0 14 14\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
                                            <path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M4.42472 12.4915C3.9691 12.0359 3.9691 11.2972 4.42472 10.8416L8.26644 6.99992L4.42472 3.1582C3.9691 2.70262 3.9691 1.96389 4.42472 1.5083C4.88032 1.05266 5.61902 1.05266 6.07462 1.5083L10.7413 6.17497C11.1969 6.63055 11.1969 7.36929 10.7413 7.82487L6.07462 12.4915C5.61902 12.9472 4.88032 12.9472 4.42472 12.4915Z\" fill=\"#0C89CD\"/>
                                        </svg>
                                </a>
                            ";


                                        for ($i = 1; $i <= $total_pages; $i++) {
                                            if ($i === $current_page || $i <= $current_page + 2 && $i >= $current_page - 2 || $i === $total_pages) {
                                                echo '<ul class="page-numbers__list">';
                                                if ($i === $current_page) {
                                                    echo '<li><a class="page-numbers current">' . $i . '</a></li>';
                                                } else {
                                                    echo '<li><a class="page-numbers" href="?page='.$i.'">' . $i . '</a></li>';
                                                }
                                                echo '</ul>';
                                            } elseif ($i === $current_page + 3 || $i === $total_pages - 1) {
                                                echo '<li><a class="page-numbers  " href="#">...</a></li>';
                                            }
                                        }


                                        if ($next_page>$total_pages)
                                        {
                                            $next_page=$total_pages;
                                            $next_page_dis = 'disabled';
                                        }

                                        echo "
                                 <a class=\"next page-numbers $next_page_dis\" href=\"?page=$next_page\">
                                     <svg width=\"14\" height=\"14\" viewBox=\"0 0 14 14\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
                                            <path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M4.42472 12.4915C3.9691 12.0359 3.9691 11.2972 4.42472 10.8416L8.26644 6.99992L4.42472 3.1582C3.9691 2.70262 3.9691 1.96389 4.42472 1.5083C4.88032 1.05266 5.61902 1.05266 6.07462 1.5083L10.7413 6.17497C11.1969 6.63055 11.1969 7.36929 10.7413 7.82487L6.07462 12.4915C5.61902 12.9472 4.88032 12.9472 4.42472 12.4915Z\" fill=\"#0C89CD\"/>
                                        </svg>
                                </a>
                            ";
                                    }

                                    ?>
                                </nav>
                                <!-- /PAGINATOR -->
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 offset-0 offset-lg-1">
                            <div class="blog_categories">
                                <h2> <a href="<?php echo get_post_type_archive_link('blog');?>">
                                        <?php echo __('All Categories',theme_domain);?>
                                    </a></h2>

                                <?php
                                    $terms = get_terms(array(
                                        'taxonomy' => 'blog_category',
                                        'hide_empty' => false,
                                        'orderby' => 'term_order',
                                        'order' => 'ASC'
                                    ));

                                    if (!empty($terms) && !is_wp_error($terms)) {
                                        echo '<ul class="categories" >';
                                        foreach ($terms as $term) {
                                            $term_link = get_term_link($term);
                                            echo '<li><a href="' . esc_url($term_link) . '">' . esc_html($term->name) . '</a></li>';
                                        }
                                        echo '</ul>';
                                    }
                                ?>

                                <h2><?php echo __('Popular Articles',theme_domain);?></h2>



                                <ul class="popular__post">
                                    <?php get_template_part( 'theme_templates/global/blog_most_popular');?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->
<?php
    get_footer();
?>