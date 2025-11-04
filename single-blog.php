<?php
    get_header();

    $post_id = get_the_ID();
    $subtitle = get_field('subtitle',$post_id);
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
        <section class="post-section blog-post-gap white__bg">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-8 col-xl-7">
                        <div class="post__wrap">
                            <article class="post">
                                <h1><?php the_title();?></h1>
                                <?php
                                $thumbnail = get_the_post_thumbnail( $post_id, 'blog-thumbnail' );
                                if ($thumbnail)
                                    echo $thumbnail;
                                ?>
                                <time datetime="<?php echo get_the_date( 'j F Y' );?>"><?php echo get_the_date( 'j F Y' );?></time>
                                <?php the_content();?>
                                <div class="post__share-btn-wrap">
                                    <a href="https://www.facebook.com/sharer.sharer.php?u=<?php echo urlencode(get_permalink($post_id));?>" class="share-btn post-facebook"><img src="<?php echo theme_url;?>/img/post-facebook.svg" alt="facebook"><span>Share</span></a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink($post_id));?>" class="share-btn post-tweet"><img src="<?php echo theme_url;?>/img/post-tweet.svg" alt="tweet"><span>tweet</span></a>
                                    <a href="https://wa.me/?text=<?php echo urlencode(get_the_title());?> <?php echo urlencode(get_permalink($post_id));?>" class="share-btn post-whatsapp"><img src="<?php echo theme_url;?>/img/whatsapp-white.svg" alt="whatsapp"><span>share</span></a>
                                    <a href="mailto:?subject=<?php echo urlencode(get_the_title());?>&body=<?php echo urlencode(get_permalink($post_id));?>" class="share-btn post-mail"><img src="<?php echo theme_url;?>/img/post-mail.svg" alt="mail"><span>email</span></a>

                                </div>
                            </article>
                            <nav class="blog-post__nav">
                                <?php
                                    $current_post_id = get_the_ID();
                                    $current_post_date = get_the_date('Y-m-d', $current_post_id);


                                    $prev_post_args = array(
                                        'post_type' => 'blog',
                                        'posts_per_page' => 1,
                                        'orderby' => 'date',
                                        'order' => 'DESC',
                                        'post__not_in' => array($current_post_id),
                                        'date_query' => array(
                                            array(
                                                'before' => $current_post_date,
                                                'inclusive' => true,
                                            ),
                                        ),
                                    );
                                    $prev_post_query = new WP_Query($prev_post_args);
                                    $prev_post_link = '';
                                    if ($prev_post_query->have_posts()) {
                                        $prev_post_query->the_post();
                                        $prev_post_link = '<a class="blog-post__nav-prev blog-post__nav-btn" href="' . esc_url(get_permalink()) . '">
                                    <span>PREVIOUS</span>
                                    <p>' . esc_html(get_the_title()) . '</p>
                               </a>';
                                    }
                                    wp_reset_postdata();


                                    $next_post_args = array(
                                        'post_type' => 'blog',
                                        'posts_per_page' => 1,
                                        'orderby' => 'date',
                                        'order' => 'ASC',
                                        'post__not_in' => array($current_post_id),
                                        'date_query' => array(
                                            array(
                                                'after' => $current_post_date,
                                                'inclusive' => true,
                                            ),
                                        ),
                                    );
                                    $next_post_query = new WP_Query($next_post_args);
                                    $next_post_link = '';
                                    if ($next_post_query->have_posts()) {
                                        $next_post_query->the_post();
                                        $next_post_link = '<a class="blog-post__nav-next blog-post__nav-btn" href="' . esc_url(get_permalink()) . '">
                                    <span>NEXT</span>
                                    <p>' . esc_html(get_the_title()) . '</p>
                               </a>';
                                    }
                                    wp_reset_postdata();

                                    if ($prev_post_link) {
                                        echo $prev_post_link;
                                    }

                                    if ($next_post_link) {
                                        echo $next_post_link;
                                    }
                                ?>

                            </nav>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 offset-0 offset-xl-1">
                        <div class="blog_categories">
                            <h2><a href="<?php echo get_post_type_archive_link('blog');?>">
                                    <?php echo __('All Categories',theme_domain);?>
                                </a>
                            </h2>
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

<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>]  -->
<?php
    get_footer();
?>
