<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->
<?php
    $post_id = get_the_ID();

    $args =[
        'post_type'      => 'blog',
        'posts_per_page' => 5,
        'orderby'        => 'rand',
        'order'          => 'ASC',
    ];

    if (is_single()) {
        $args['post__not_in']=[$post_id];
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

            $content = wp_trim_words($itemp->post_content, 14, '');

            echo "
                    <li class=\"blog_item\">
                        <a href=\"$link\">
                            $im_out
                            <div>
                                <h5>$itemp->post_title</h5>
                                <time datetime=\"$itemp->post_date\">$fdate</time>
                            </div>
                        </a>
                    </li>
            ";
        }
}
?>
<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->