<?php
/*
function dequeue_woocommerce_styles() {
    // Вимкнення стилів WooCommerce
    wp_dequeue_style('woocommerce-general'); // Основні стилі
    wp_dequeue_style('woocommerce-layout'); // Стилі макету
    wp_dequeue_style('woocommerce-smallscreen'); // Стилі для маленьких екранів
}
add_action('wp_enqueue_scripts', 'dequeue_woocommerce_styles', 99);

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_after_shop_loop', 'woocommerce_output_content_wrapper_end', 10);
*/

/**
 * For header list woocommerce categories
 */
function display_woocommerce_categories() {

    $list_cat= get_field('header','option');

    if (isset($list_cat['list_category']) && count($list_cat['list_category']) )
    {
        echo '<ul class="header__prod-categories-list">';
        foreach ($list_cat['list_category'] as $k=>$v)
        {
            $category_link = get_term_link($v);
            echo '<li class="header__prod-categories-item">';
            echo '<a href="' . esc_url($category_link) . '">' . esc_html($v->name) . '</a>';
            echo '</li>';
        }
        echo '</ul>';
    }

    return;

    $categories = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'parent' => 0,
        'exclude' => [get_option('default_product_cat')],
    ]);

    if ($categories) {
        echo '<ul class="header__prod-categories-list">';
        foreach ($categories as $category) {
            $category_link = get_term_link($category);
            echo '<li class="header__prod-categories-item">';
            echo '<a href="' . esc_url($category_link) . '">' . esc_html($category->name) . '</a>';

            $subcategories = get_terms([
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'parent' => $category->term_id,
            ]);

            if ($subcategories) {
                echo '<ul class="header-prod__submenu">';
                foreach ($subcategories as $subcategory) {
                    $subcategory_link = get_term_link($subcategory);
                    echo '<li><a href="' . esc_url($subcategory_link) . '">' . esc_html($subcategory->name) . '</a></li>';
                }
                echo '</ul>';
            }

            echo '</li>';
        }
        echo '</ul>';
    }
}

/**
 * For header mobile list woocommerce categories
 */
function display_woocommerce_categories_mobile_menu() {
    $categories = get_terms([
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        'parent' => 0,
        'exclude' => [get_option('default_product_cat')],
    ]);

    if ($categories) {
        echo '<div class="header-mobile-menu">';
        echo '<ul class="header__prod-categories-list">';
        foreach ($categories as $category) {
            echo '<li class="header__prod-categories-item">' . esc_html($category->name);

            $subcategories = get_terms([
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'parent' => $category->term_id,
            ]);

            if ($subcategories) {
                echo '<ul class="header-prod__submenu">';
                foreach ($subcategories as $subcategory) {
                    $subcategory_link = get_term_link($subcategory);
                    echo '<li><a href="' . esc_url($subcategory_link) . '">' . esc_html($subcategory->name) . '</a></li>';
                }
                echo '</ul>';
            }

            echo '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
}


function custom_add_to_cart_redirect() {
    if (isset($_GET['add-to-cart']) && is_numeric($_GET['add-to-cart'])) {
        $product_id = (int)$_GET['add-to-cart'];
        WC()->cart->add_to_cart($product_id);

        wp_safe_redirect(remove_query_arg('add-to-cart'));
        exit;
    }
}
add_action('template_redirect', 'custom_add_to_cart_redirect');


/*add_action('wp_enqueue_scripts', function() {
    global $wp_styles;

    foreach ($wp_styles->registered as $style) {
       // error_log('Style handle: ' . $style->handle . ' - ' . $style->src);
        echo $style->handle.' '.$style->src."\n <br>";
    }
});*/



add_action('wp_enqueue_scripts', function() {
    wp_dequeue_style('wc-blocks-style-checkout'); // 'wc-blocks-checkout' — це handle стилю
    wp_deregister_style('wc-blocks-style-checkout');
}, 200);


//------------------------------------------

// text object to array
function convertObjectTextToArray($text) {
    $text = preg_replace('/:\w+/', '', $text);
    $text = str_replace('Array', '', $text);
    return parseArray($text);
}

function parseArray($text) {
    $text = trim($text, " \n\r\t\v\x00{}");
    $lines = explode("\n", $text);
    $array = [];
    $key = null;
    $isArray = false;
    $currentArray = [];
    $depth = 0;

    foreach ($lines as $line) {
        $line = trim($line);

        if (strpos($line, 'Array') === 0) {
            $isArray = true;
            continue;
        }

        if (preg_match('/^\[(\d+)\]\s*=>\s*(.*)$/', $line, $matches)) {
            $index = $matches[1];
            $value = trim($matches[2], " \n\r\t\v\x00\"'");
            $currentArray[$index] = $value;
        } elseif (preg_match('/^\[(.*?)\]\s*=>\s*(.*)$/', $line, $matches)) {
            if ($isArray) {
                $array = $currentArray;
                $currentArray = [];
                $isArray = false;
            }
            $key = trim($matches[1]);
            $value = trim($matches[2]);
            if (strpos($value, '{') === 0) {
                $depth++;
                $nestedArray = parseArray(substr($value, 1));
                $array[$key] = $nestedArray;
                $depth--;
            } else {
                $array[$key] = trim($value, " \n\r\t\v\x00\"'");
            }
        }
    }

    if ($isArray) {
        $array = $currentArray;
    }

    return $array;
}


add_filter('bcn_after_fill', 'custom_breadcrumb_html_elements');
function custom_breadcrumb_html_elements($breadcrumb_trail)
{
    if (!is_shop() && !is_tax('product_cat')) {
        return $breadcrumb_trail;
    }

    if (is_shop() || is_tax('product_cat'))
    {
        $el = [];

        foreach ($breadcrumb_trail->breadcrumbs as $key => $crumb) {

            $text_object = print_r($crumb, 1);
            $info = convertObjectTextToArray($text_object);

            $el[] = $info;
        }

        if (is_array($el) && count($el)) {
            $reversedArray = array_reverse($el);

            $sep = '<span class="breadcrumbs__separator"> / </span>';
            foreach ($reversedArray as $key => $value) {
                if ($key < 1) {
                    echo '<span><a class="breadcrumbs__link" href="' . esc_url($value['url']) . '"><span>' . esc_html($value['template_no_anchor']) . '</span></a></span>' . $sep;
                } else {
                    if ($key != count($reversedArray) - 1) {
                        if ($value['title'] == 'Products')
                            $value['title'] = 'Shop';

                        echo '<span><a class="breadcrumbs__link" href="' . esc_url($value['url']) . '"><span>' . esc_html($value['title']) . '</span></a></span>' . $sep;
                    } else {
                        echo '<span class="breadcrumbs__current">' . esc_html($value['title']) . '</span>';
                    }
                }
            }
        }
    }

    unset($breadcrumb_trail->breadcrumbs);
    return $breadcrumb_trail;
}

function get_min_max_price_by_category_id($category_id = 0) {

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_price',
                'compare' => 'EXISTS',
            ),
        ),
    );

    if ($category_id > 0) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $category_id,
            ),
        );
    }

    $query = new WP_Query($args);
    $prices = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $price = get_post_meta(get_the_ID(), '_price', true);

            if ($price !== '') {
               // $prices[] = (float) $price;
            }

            $product = wc_get_product(get_the_ID());

            if ($product->is_type('variable')) {
                $variations = $product->get_available_variations();

                foreach ($variations as $variation) {


                    if (isset($variation['attributes']['attribute_pa_count-by']) && $variation['attributes']['attribute_pa_count-by']=='basic-price' )
                    {
                        $price = (float) $variation['display_price'];
                        $prices[] = $price;
                    }
                }
            }
        }
        wp_reset_postdata();
    }

    if (!empty($prices)) {
        $min_price = min($prices);
        $max_price = max($prices);
        return array('min' => $min_price, 'max' => $max_price);
    } else {
        return array('min' => 0, 'max' => 0);
    }
}

function get_product_count_in_term($term_id,$taxonomy='',$current_cat=0) {

    $args = array(
        'post_type' => 'product',
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        ),
        'posts_per_page' => -1,
    );

    if ((int)$current_cat>0)
    {
        $args['tax_query']=[
            'relation'=>'AND',
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $current_cat,
            ),
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'term_id',
                'terms'    => $term_id,
            ),
        ];
    }
    $query = new WP_Query($args);
    return $query->found_posts;
}

define( 'COUNT_PROD_FILTER', 6 );


class woocomerce_product
{
    public function __construct()
    {

    }

    private function request($inp_term_id=0)
    {

        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' =>COUNT_PROD_FILTER,
            'paged' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
        );


        if (!$inp_term_id)
        {
            $term = get_queried_object();
            $term_id = $term->term_id;
        }
        else
        {
            $term_id = $inp_term_id;
        }

        if (isset($_POST['term_id']) && (int)$_POST['term_id']>0)
        {
            $term_id = (int)$_POST['term_id'];
        }

        if ($term_id>0)
        {
            $args['tax_query']=[
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $term_id,
                ]
            ];
        }

        return $args;
    }

    public function get_product($term_id=0)
    {
        $args = $this->request($term_id);


        $query = new WP_Query( $args );
        $posts = $query->get_posts();


        $prod_html='';
        if (is_array( $posts) && count( $posts))
        {
            foreach ($posts as $key => $item)
            {
                set_query_var('product_id',$item->ID);
                ob_start();
                get_template_part( 'theme_templates/global/products_item_shop');
                $prod_html.= ob_get_contents();
                ob_end_clean();
            }
        }
        else
        {
            $prod_html='<p>Product not found.</p>';
        }

        return [
           'html'=>$prod_html,
           'pag'=>generate_pagination_html($query->max_num_pages, 1),
        ];
    }
}

$woocomerce_product = new woocomerce_product();

//-------------- FILTER ---------

add_action('wp_ajax_filter_products', 'filter_products');
add_action('wp_ajax_nopriv_filter_products', 'filter_products');
function filter_products_old1() {

    $data = $_POST['filter'];

    $price_min = isset($data['price']['min']) ? intval($data['price']['min']) : 0;
    $price_max = isset($data['price']['max']) ? intval($data['price']['max']) : PHP_INT_MAX;
    $taxonomy = isset($data['taxonomy']) ? $data['taxonomy'] : [];
    $category_id = isset($data['category_id']) ? (int)$data['category_id'] : 0;
    $sorted = isset($data['sorted']) ? sanitize_text_field($data['sorted']) : 'menu_order';
    $paged = isset($data['page']) ? intval($data['page']) : 1;
    $s = isset($data['s']) ? sanitize_text_field($data['s']) : '';

    $per_page = COUNT_PROD_FILTER;

    $args = [
        'post_type' => 'product',
        'posts_per_page' => $per_page,
        'paged' => $paged,
        'orderby' => $sorted,
        'order' => 'ASC',
    ];

    if ($s!='')
    {
        $args['s']=$s;
    }

    if ($sorted === 'price' || $sorted === 'price-desc') {
       /* $args['meta_key'] = '_price';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = ($sorted === 'price') ? 'ASC' : 'DESC';*/
        $args['meta_query'] = [
            [
                'key' => '_price',
                'compare' => 'EXISTS',
                'type' => 'NUMERIC'
            ]
        ];
        $args['orderby'] = 'meta_value_num';
        $args['order'] = ($sorted === 'price') ? 'ASC' : 'DESC';
    } elseif ($sorted === 'date') {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    } elseif ($sorted === 'popularity') {
        $args['meta_key'] = 'total_sales';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
    } elseif ($sorted === 'rating') {
        $args['meta_key'] = '_wc_average_rating';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
    }

    if ($price_min || $price_max)
    {
        $price_min = (float)$price_min;
        $price_max = (float)$price_max;

        if ($price_min>$price_max)
        {
            $pt=$price_min;
            $price_min = $price_max;
            $price_max = $pt;
        }

        $args['meta_query']=[
            'key' => '_price',
            'value' => [$price_min, $price_max],
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC',
        ];
    }

    $args['tax_query']=[];

    if ($category_id!=0)
    {
        $args['tax_query'][]=[
            'relation'=>'AND',
        ];
        $args['tax_query'][] = [
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $category_id,
        ];
    }

    if ($category_id==0 && count($taxonomy)>1)
    {
        $args['tax_query'][]=[
            'relation'=>'AND',
        ];
    }

    if (is_array($taxonomy) && count($taxonomy)) {

        foreach ($taxonomy as $taxonomy_key => $terms) {
            if (!empty($terms)) {
                $args['tax_query'][] = [
                    'taxonomy' => $taxonomy_key,
                    'field' => 'term_id',
                    'terms' => $terms,
                    'operator' => 'IN', // OR логіка
                ];
            }
        }
    }

    $query = new WP_Query($args);
    $products_html = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            set_query_var('product_id',get_the_ID());
            ob_start();
            get_template_part( 'theme_templates/global/products_item_shop');
            $products_html.= ob_get_contents();
            ob_end_clean();

        }
    }

    $total_pages = $query->max_num_pages;
    $pag_html = generate_pagination_html($total_pages, $paged);


    wp_send_json_success([
        'html' => $products_html,
        'counter_products' =>filt_count(),
        'pag' => $pag_html,
        '$args' => $args,
        'query' => $query->request,
        '$_POST' => $_POST,
    ]);
}

function filter_products() {

    $data = $_POST['filter'];

    $price_min = isset($data['price']['min']) ? (float)$data['price']['min'] : 0;
    $price_max = isset($data['price']['max']) ? (float)$data['price']['max'] : PHP_INT_MAX;
    $taxonomy = isset($data['taxonomy']) ? $data['taxonomy'] : [];
    $category_id = isset($data['category_id']) ? (int)$data['category_id'] : 0;
    $sorted = isset($data['sorted']) ? sanitize_text_field($data['sorted']) : 'menu_order';
    $paged = isset($data['page']) ? intval($data['page']) : 1;
    $s = isset($data['s']) ? sanitize_text_field($data['s']) : '';

    $per_page = COUNT_PROD_FILTER;

    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'orderby' => $sorted,
        'order' => 'ASC',
    ];

    if ($s != '') {
        $args['s'] = $s;
    }

    $args['tax_query']=[];

    if ($category_id!=0)
    {
        $args['tax_query'][]=[
            'relation'=>'AND',
        ];
        $args['tax_query'][] = [
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $category_id,
        ];
    }

    if ($category_id==0 && count($taxonomy)>1)
    {
        $args['tax_query'][]=[
            'relation'=>'AND',
        ];
    }

    if (is_array($taxonomy) && count($taxonomy)) {

        foreach ($taxonomy as $taxonomy_key => $terms) {
            if (!empty($terms)) {
                $args['tax_query'][] = [
                    'taxonomy' => $taxonomy_key,
                    'field' => 'term_id',
                    'terms' => $terms,
                    'operator' => 'IN', // OR логіка
                ];
            }
        }
    }

    /*
    $args['tax_query'] = [];
    if ($category_id != 0) {
        $args['tax_query'][] = [
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $category_id,
        ];
    }

    if (is_array($taxonomy) && count($taxonomy)) {
        foreach ($taxonomy as $taxonomy_key => $terms) {
            if (!empty($terms)) {
                $args['tax_query'][] = [
                    'taxonomy' => $taxonomy_key,
                    'field' => 'term_id',
                    'terms' => $terms,
                    'operator' => 'IN',
                ];
            }
        }
    }

    */

    $query = new WP_Query($args);
    $filtered_products = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $product = wc_get_product(get_the_ID());
            if ($product && $product->is_type('variable')) {
                $variations = $product->get_available_variations();


                if (!empty($variations)) {
                    $first_variation = $variations[0];
                    $variation_price = (float) $first_variation['display_price'];

                    if ($price_min && $price_max) {
                        if ($variation_price >= $price_min && $variation_price <= $price_max) {
                            $filtered_products[] = [
                                'product_id' => $product->get_id(),
                                'variation_id' => $first_variation['variation_id'],
                                'price' => $variation_price,
                            ];
                        }
                    }
                    else
                    {
                        $filtered_products[] = [
                            'product_id' => $product->get_id(),
                            'variation_id' => $first_variation['variation_id'],
                            'price' => $variation_price,
                        ];
                    }
                }
            } elseif ($product && $product->is_type('simple')) {
                $product_price = (float) $product->get_price();

                if ($price_min && $price_max)
                {
                    if ($product_price >= $price_min && $product_price <= $price_max) {
                        $filtered_products[] = [
                            'product_id' => $product->get_id(),
                            'price' => $product_price,
                        ];
                    }
                }
                else
                {
                    $filtered_products[] = [
                        'product_id' => $product->get_id(),
                        'price' => $product_price,
                    ];
                }
            }
        }
    }

    // sorted
    if ($sorted === 'price' || $sorted === 'price-desc') {
        usort($filtered_products, function($a, $b) use ($sorted) {
            if ($sorted === 'price') {
                return $a['price'] <=> $b['price'];
            } else {
                return $b['price'] <=> $a['price'];
            }
        });
    }

    $paged_products = array_slice($filtered_products, ($paged - 1) * $per_page, $per_page);
    $products_html = '';

    foreach ($paged_products as $product_data) {
        set_query_var('product_id', $product_data['product_id']);
        ob_start();
        get_template_part('theme_templates/global/products_item_shop');
        $products_html .= ob_get_contents();
        ob_end_clean();
    }

    $total_pages = ceil(count($filtered_products) / $per_page);
    $pag_html = generate_pagination_html($total_pages, $paged);

    wp_send_json_success([
        'html' => $products_html,
        //'counter_products' => count($filtered_products),
        'counter_products' => filt_count(),
        'pag' => $pag_html,

        '$args' => $args,
        'query' => $query->request,
        '$_POST' => $_POST,
    ]);
}


function generate_pagination_html($total_pages, $current_page) {
    if ($total_pages <= 1) return '';

    //var_dump($total_pages);
   // $pag_html = '<nav class="pagination woocommerce-pagination wd-pagination">';
    $pag_html = '';
    $pag_html .= '<a class="prev page-numbers filter_pag ' . ($current_page == 1 ? 'inactive' : '') . '" href="#" data-page="'.( ($current_page>1)?$current_page-1:$current_page).'" ><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.42472 12.4915C3.9691 12.0359 3.9691 11.2972 4.42472 10.8416L8.26644 6.99992L4.42472 3.1582C3.9691 2.70262 3.9691 1.96389 4.42472 1.5083C4.88032 1.05266 5.61902 1.05266 6.07462 1.5083L10.7413 6.17497C11.1969 6.63055 11.1969 7.36929 10.7413 7.82487L6.07462 12.4915C5.61902 12.9472 4.88032 12.9472 4.42472 12.4915Z" fill="#0C89CD"/>
                                            </svg></a>';
    $pag_html .= '<ul class="page-numbers__list">';

    for ($i = 1; $i <= $total_pages; $i++) {
        $pag_html .= '<li><a class="page-numbers filter_pag ' . ($current_page == $i ? 'current' : '') . '" href="#" data-page="'.$i.'">' . $i . '</a></li>';
    }

    $pag_html .= '</ul>';
    $pag_html .= '<a class="next page-numbers filter_pag' . ($current_page == $total_pages ? 'inactive' : '') . '" href="#" data-page="'.( ($current_page<$total_pages)?$current_page+1:$current_page).'" ><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.42472 12.4915C3.9691 12.0359 3.9691 11.2972 4.42472 10.8416L8.26644 6.99992L4.42472 3.1582C3.9691 2.70262 3.9691 1.96389 4.42472 1.5083C4.88032 1.05266 5.61902 1.05266 6.07462 1.5083L10.7413 6.17497C11.1969 6.63055 11.1969 7.36929 10.7413 7.82487L6.07462 12.4915C5.61902 12.9472 4.88032 12.9472 4.42472 12.4915Z" fill="#0C89CD"/>
                                            </svg></a>';
   // $pag_html .= '</nav>';

    return $pag_html;
}

function filt_count() {
    $data = $_POST['filter'];

    $price_min = isset($data['price']['min']) ? intval($data['price']['min']) : 0;
    $price_max = isset($data['price']['max']) ? intval($data['price']['max']) : PHP_INT_MAX;
    $taxonomy = isset($data['taxonomy']) ? $data['taxonomy'] : [];
    $category_id = isset($data['category_id']) ? (int)$data['category_id'] : 0;
    $s = isset($data['s']) ? sanitize_text_field($data['s']) : '';

    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
    ];

    if ($s != '') {
        $args['s'] = $s;
    }

    $filter_terms = [];
    if (is_array($taxonomy) && count($taxonomy)) {
        foreach ($taxonomy as $taxonomy_key => $terms) {
            foreach ($terms as $terms_id) {
                $filter_terms[] = get_term($terms_id);
            }
        }
    }

    $all_terms = [];
    $terms = get_terms(array(
        'taxonomy' => ['prod_type', 'brand', 'special_interests'],
        'hide_empty' => false,
    ));

    if (!is_wp_error($terms) && !empty($terms)) {
        foreach ($terms as $term) {
            if (!in_array($term->term_id, $filter_terms)) {
                $all_terms[] = $term;
            }
        }
    }

    //--------------------------------------------

    if ($price_min && $price_max) {
        $price_min = (float)$price_min;
        $price_max = (float)$price_max;

        if ($price_min > $price_max) {
            $pt = $price_min;
            $price_min = $price_max;
            $price_max = $pt;
        }

        // Фільтрація за ціною буде додана лише в циклі
    }

    $counters = [];
    if (is_array($all_terms) && count($all_terms)) {
        $args['tax_query'] = [];
        if ($category_id && $category_id != 0) {
            $args['tax_query'][] = [
                'relation' => 'AND',
            ];
            $args['tax_query'][] = [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category_id,
                'include_children' => false,
            ];
        }

        if (is_array($filter_terms) && count($filter_terms)) {
            foreach ($filter_terms as $term) {
                // Створюємо tax_query для поточного терміну
                $args['tax_query'][] = [
                    'taxonomy' => $term->taxonomy,
                    'field' => 'term_id',
                    'terms' => $term->term_id,
                ];

                foreach ($all_terms as $term_a) {
                    // Перевіряємо фільтрацію для кожного терміну в tax_query
                    if ($term->taxonomy === $term_a->taxonomy && $term->term_id === $term_a->term_id) {
                        continue; // Пропускаємо терміни, які вже активні
                    }

                    // Додаємо інші терміни до запиту
                    $args['tax_query'][] = [
                        'taxonomy' => $term_a->taxonomy,
                        'field' => 'term_id',
                        'terms' => $term_a->term_id,
                    ];

                    // Оновлюємо запит і фільтруємо за ціною
                    $query = new WP_Query($args);
                    if ($price_min && $price_max) {
                        $filtered_count = 0;
                        while ($query->have_posts()) {
                            $query->the_post();
                            $product = wc_get_product(get_the_ID());

                            // Перевіряємо, чи є варіації і беремо першу варіацію для ціни
                            if ($product && $product->is_type('variable')) {
                                $variations = $product->get_available_variations();
                                if (!empty($variations)) {
                                    $first_variation = $variations[0];
                                    $variation_price = (float)$first_variation['display_price'];
                                    if ($variation_price >= $price_min && $variation_price <= $price_max) {
                                        $filtered_count++;
                                    }
                                }
                            } elseif ($product && $product->is_type('simple')) {
                                $product_price = (float)$product->get_price();
                                if ($product_price >= $price_min && $product_price <= $price_max) {
                                    $filtered_count++;
                                }
                            }
                        }
                        $counters[] = [
                            'count' => $filtered_count,
                            'all_terms' => $term_a->term_id,
                            'filter_term' => $term->term_id,
                            'query' => $query->request,
                        ];
                    } else {
                        $counters[] = [
                            'count' => $query->found_posts,
                            'all_terms' => $term_a->term_id,
                            'filter_term' => $term->term_id,
                            'query' => $query->request,
                        ];
                    }

                    array_pop($args['tax_query']);
                }
            }
        } else {
            foreach ($all_terms as $term_a) {
                $args['tax_query'][] = [
                    'taxonomy' => $term_a->taxonomy,
                    'field' => 'term_id',
                    'terms' => $term_a->term_id,
                ];

                $query = new WP_Query($args);

                // Фільтрація за ціною всередині циклу
                if ($price_min && $price_max) {
                    $filtered_count = 0;
                    while ($query->have_posts()) {
                        $query->the_post();
                        $product = wc_get_product(get_the_ID());

                        // Перевіряємо, чи є варіації і беремо першу варіацію для ціни
                        if ($product && $product->is_type('variable')) {
                            $variations = $product->get_available_variations();
                            if (!empty($variations)) {
                                $first_variation = $variations[0];
                                $variation_price = (float)$first_variation['display_price'];
                                if ($variation_price >= $price_min && $variation_price <= $price_max) {
                                    $filtered_count++;
                                }
                            }
                        } elseif ($product && $product->is_type('simple')) {
                            $product_price = (float)$product->get_price();
                            if ($product_price >= $price_min && $product_price <= $price_max) {
                                $filtered_count++;
                            }
                        }
                    }
                    $counters[] = [
                        'count' => $filtered_count,
                        'all_terms' => $term_a->term_id,
                        'filter_term' => 0,
                    ];
                } else {
                    $counters[] = [
                        'count' => $query->found_posts,
                        'all_terms' => $term_a->term_id,
                        'filter_term' => 0,
                        'query' => $query->request,
                    ];
                }

                array_pop($args['tax_query']);
            }
        }
    }

    return [
        '$all_terms' => $all_terms,
        '$filter_terms' => $filter_terms,
        'counters' => $counters,
    ];
}



function filt_count_old1()
{
    $data = $_POST['filter'];

    $price_min = isset($data['price']['min']) ? intval($data['price']['min']) : 0;
    $price_max = isset($data['price']['max']) ? intval($data['price']['max']) : PHP_INT_MAX;
    $taxonomy = isset($data['taxonomy']) ? $data['taxonomy'] : [];
    $category_id = isset($data['category_id']) ? (int)$data['category_id'] : 0;
    $s = isset($data['s']) ? sanitize_text_field($data['s']) : '';

    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
    ];

    if ($s!='')
    {
        $args['s']=$s;
    }

    $filter_terms=[];
    if (is_array($taxonomy) && count($taxonomy)) {
        foreach ($taxonomy as $taxonomy_key => $terms) {
            foreach ($terms as $terms_id) {
               // $filter_terms[]=$terms_id;
                $filter_terms[]= get_term($terms_id);
            }
        }
    }

    $all_terms=[];
    $terms = get_terms(array(
        'taxonomy' => ['prod_type','brand','special_interests'],
        'hide_empty' => false,
    ));
    if (!is_wp_error($terms) && !empty($terms))
    {
        foreach ($terms as $term)
        {
            if(!in_array($term->term_id,$filter_terms))
            {
                $all_terms[] = $term;
            }
        }
    }

    //--------------------------------------------

    if ($price_min || $price_max)
    {
        $price_min = (float)$price_min;
        $price_max = (float)$price_max;

        if ($price_min>$price_max)
        {
            $pt=$price_min;
            $price_min = $price_max;
            $price_max = $pt;
        }

        $args['meta_query']=[
            'key' => '_price',
            'value' => [$price_min, $price_max],
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC',
        ];
    }

    $counters=[];
    if (is_array($all_terms) && count($all_terms))
    {
        $args['tax_query'] = [];
        if ($category_id && $category_id!=0 ) {
            $args['tax_query'][] = [
                'relation' => 'AND',
            ];
            $args['tax_query'][] = [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category_id,
                'include_children' => false,
            ];
        }

        if (is_array($filter_terms) && count($filter_terms))
        {
            foreach ($filter_terms as $term)
            {
                $args['tax_query'][] = [
                    'taxonomy' => $term->taxonomy,
                    'field' => 'term_id',
                    'terms' => $term->term_id,
                ];

                foreach ($all_terms as $term_a)
                {
                    $args['tax_query'][] = [
                        'taxonomy' => $term_a->taxonomy,
                        'field' => 'term_id',
                        'terms' => $term_a->term_id,
                    ];

                    $query = new WP_Query($args);

                    array_pop($args['tax_query']);

                    $counters[]=[
                        'count'=>$query->found_posts,
                        'all_terms'=>$term_a->term_id,
                        'filter_term'=>$term->term_id,
                        'query'=>$query->request,
                    ];
                }
            }
        }
        else
        {
            foreach ($all_terms as $term_a)
            {
                $args['tax_query'][] = [
                    'taxonomy' => $term_a->taxonomy,
                    'field' => 'term_id',
                    'terms' => $term_a->term_id,
                ];

                $query = new WP_Query($args);

                array_pop($args['tax_query']);

                $counters[]=[
                    'count'=>$query->found_posts,
                    'all_terms'=>$term_a->term_id,
                    'filter_term'=>0,
                ];
            }
        }


    }


    return [
        '$all_terms'=>$all_terms,
        '$filter_terms'=>$filter_terms,
        'counters'=>$counters,
    ];
}

//--------------------------------------

add_action('woocommerce_variation_options', 'add_custom_table_to_variations', 10, 3);
function add_custom_table_to_variations($loop, $variation_data, $variation) {
    $rows = get_post_meta($variation->ID, '_custom_table_data', true);

    echo '<div class="custom-variation-table" style="margin-top: 15px;">';
    echo '<label>Discount for user:</label>';
    echo '<table class="wp-list-table">';
    echo '<thead><tr><th>User</th><th>Percentage</th><th>Action</th></tr></thead>';
    echo '<tbody>';

    if ($rows) {
        foreach ($rows as $index => $row) {
            echo '<tr>';
            echo '<td>' . wp_dropdown_users(array(
                    'name' => 'custom_table_user_' . esc_attr($variation->ID) . '[]',
                   // 'role' => 'company',
                    'echo' => false,
                    'selected' => esc_attr($row['user']),
                    'show_option_none' => 'Select user'
                )) . '</td>';
            echo '<td><input type="text" name="custom_table_text_' . esc_attr($variation->ID) . '[]" value="' . esc_attr($row['text']) . '" /></td>';
            echo '<td><button type="button" class="button remove-row">X</button></td>';
            echo '</tr>';
        }
    }

    echo '</tbody>';
    echo '</table>';
    echo '<button type="button" class="button add-row" data-variation-id="' . esc_attr($variation->ID) . '">Add</button>';
    echo '</div>';
}


add_action('admin_footer', 'add_custom_table_scripts');
function add_custom_table_scripts() {
    if ('product' !== get_post_type()) return;
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(document).on('click','.add-row', function() {
                var variationId = $(this).data('variation-id');
                var newRow = '<tr>';
                newRow += `<td><?php echo wp_dropdown_users(array(
                    'name' => 'custom_table_user_' . 'VARIATION_ID' . '[]',
                   // 'role' => 'company',
                    'echo' => false,
                    'show_option_none' => 'Select user'
                )); ?></td>`;
                newRow += '<td><input type="text" name="custom_table_text_' + variationId + '[]" /></td>';
                newRow += '<td><button type="button" class="button remove-row">X</button></td>';
                newRow = newRow.replace(/VARIATION_ID/g, variationId);
                $(this).prev('table').find('tbody').append(newRow);
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>
    <?php
}

add_action('woocommerce_save_product_variation', 'save_custom_table_data_for_variation', 10, 2);
function save_custom_table_data_for_variation($variation_id, $i) {
    if (isset($_POST['custom_table_user_' . $variation_id]) && isset($_POST['custom_table_text_' . $variation_id])) {
        $table_data = array();
        $users = $_POST['custom_table_user_' . $variation_id];
        $texts = $_POST['custom_table_text_' . $variation_id];

        foreach ($users as $index => $user) {
            if (!empty($user) || !empty($texts[$index])) {
                $table_data[] = array(
                    'user' => sanitize_text_field($user),
                    'text' => sanitize_text_field($texts[$index])
                );
            }
        }

        // Якщо є заповнені рядки, оновлюємо мета-поле; якщо немає — видаляємо його
        if (!empty($table_data)) {
            update_post_meta($variation_id, '_custom_table_data', $table_data);
        } else {
            delete_post_meta($variation_id, '_custom_table_data');
        }
    } else {
        delete_post_meta($variation_id, '_custom_table_data');
    }
}



add_action('wp_ajax_add_to_cart', 'handle_add_to_cart_custom');
add_action('wp_ajax_nopriv_add_to_cart', 'handle_add_to_cart_custom');
function handle_add_to_cart_custom() {
    if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
        wp_send_json_error(['message' => 'Missing product ID or quantity']);
        return;
    }

    $product_id = intval($_POST['product_id']);
    $variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;
    $quantity = intval($_POST['quantity']);

    $product = wc_get_product($product_id);
    if (!$product || ($variation_id && !$product->is_type('variable'))) {
        wp_send_json_error(['message' => 'Invalid product or variation']);
        return;
    }

    if ($variation_id && !wc_get_product($variation_id)) {
        wp_send_json_error(['message' => 'Invalid variation ID']);
        return;
    }

    if (is_user_company())
    {
        $productx = wc_get_product($variation_id);
        $original_price = $productx->get_price();
        $price = personal_discount($variation_id,$original_price,0)['regular_price'];

        $cart_item_data = [
            'custom_price' => $price
        ];

        $added = WC()->cart->add_to_cart($product_id, $quantity, $variation_id,[], $cart_item_data);

    }
    else
    {
        $added = WC()->cart->add_to_cart($product_id, $quantity, $variation_id);
    }

    if ($added)
    {
        wp_send_json_success(
            [
                'message' => 'Product added to cart successfully',
                'count'=>WC()->cart?WC()->cart->get_cart_contents_count():0,
            ]
        );
    } else {
        wp_send_json_error(['message' => 'Failed to add product to cart']);
    }
}

function disable_woocommerce_block_editor_styles() {
    wp_deregister_style( 'wc-block-editor' );
    wp_deregister_style( 'wc-block-style' );
}
add_action( 'enqueue_block_assets', 'disable_woocommerce_block_editor_styles', 1, 1 );

add_action('wp_ajax_custom_update_cart', 'custom_update_cart');
add_action('wp_ajax_nopriv_custom_update_cart', 'custom_update_cart');
function custom_update_cart() {
    if (isset($_POST['cart_item_key']) && isset($_POST['new_quantity'])) {
        $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
        $new_quantity = intval($_POST['new_quantity']);

        $cart = WC()->cart->get_cart();
        if (array_key_exists($cart_item_key, $cart)) {
            WC()->cart->set_quantity($cart_item_key, $new_quantity);
            WC()->cart->calculate_totals(); // Перерахунок підсумків кошика

            wp_send_json_success('Update');
        } else {
            wp_send_json_error('Not find product');
        }
    } else {
        wp_send_json_error('Error request');
    }
}

//-------------------------- DISCOUNT -------------------------------------------------
function is_user_company() {
    if (is_user_logged_in()) {
        $user = wp_get_current_user();
        return in_array('company', (array) $user->roles);
    }
    return false;
}

function personal_discount($variation_id=0,$regular_price=0,$sale_price=0)
{
    if (is_user_company())
    {
        $rows = get_post_meta($variation_id, '_custom_table_data', true);

        if (is_array($rows) && count($rows))
        {
            $user = wp_get_current_user();
            $user_id = $user->ID;
            foreach ($rows as $item)
            {
                if ( (int)$item['user']==$user_id)
                {
                    $percent = (float)$item['text'];

                    if ($percent>1)
                    {
                        $percent = $percent/100;
                        if ($regular_price && $regular_price!=0)
                            $regular_price = round($regular_price - ($regular_price*$percent),2);
                        if ($sale_price && $sale_price!=0)
                            $sale_price = round($sale_price - ($sale_price*$percent),2);
                    }
                }
            }
        }
    }

    return [
        'regular_price' =>$regular_price,
        'sale_price' =>$sale_price,
    ];
}

function get_list_discount()
{
    global $wpdb;

    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = %s",
            '_custom_table_data'
        )
    );

    $user = wp_get_current_user();
    $user_id = $user->ID;

    $dis_values=0;
    if ( ! empty( $results ) )
    {
        foreach ( $results as $row )
        {
            if ($row->meta_value )
            {
                $uns = unserialize($row->meta_value);

                if (is_array($uns) && count($uns))
                {
                    foreach ($uns as $item)
                    {
                        if ( (int)$item['user'] == $user_id) {
                            $dis_values = $item['text'];
                            return $dis_values;
                        }
                    }
                }
            }
        }
    }

    return $dis_values;
}


add_action('woocommerce_before_calculate_totals', 'set_custom_price_in_cart', 10);
function set_custom_price_in_cart($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;


    //$total_quantity = $cart->get_cart_contents_count();




    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if (isset($cart_item['custom_price']) && (float)$cart_item['custom_price']>0 ) {
            $cart_item['data']->set_price($cart_item['custom_price']);
        }
    }


    foreach ($cart->get_cart() as $cart_item_key => $cart_item)
    {
        $total_quantity = $cart_item['quantity'];

        $discount_percentage = 0;
        if ($total_quantity >= 20) {
            $discount_percentage = 20;
        } elseif ($total_quantity >= 15) {
            $discount_percentage = 15;
        } elseif ($total_quantity >= 10) {
            $discount_percentage = 10;
        }

        if ($discount_percentage) {
            $product_price = $cart_item['data']->get_price();
            $discounted_price = $product_price * (1 - $discount_percentage / 100);
            $cart_item['data']->set_price($discounted_price);
        }
    }

}

//--------------- CHECK OUT ------

remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );


add_action('woocommerce_checkout_process', 'custom_checkout_field_validation');
function custom_checkout_field_validation() {
    $checkout_fields = WC()->checkout()->get_checkout_fields('shipping');

    foreach ($checkout_fields as $field_key => $field) {
        if (!empty($field['required']) && isset($_POST[$field_key]) && empty($_POST[$field_key])) {
            wc_add_notice(sprintf(__('The %s field is required.', 'woocommerce'), $field['label']), 'error');
        }
    }
}


function update_shipping_method() {
    if ( isset($_POST['shipping_method']) ) {
        $shipping_method = sanitize_text_field($_POST['shipping_method']);
        WC()->session->set( 'chosen_shipping_methods', array( $shipping_method ) );

        ob_start();
        wc_get_template( 'checkout/review-order.php' );
        $html = ob_get_clean();

        wp_send_json_success(array( 'html' => $html ));
    }
}
add_action( 'wp_ajax_update_shipping_method', 'update_shipping_method' );
add_action( 'wp_ajax_nopriv_update_shipping_method', 'update_shipping_method' );


add_action( 'wp_ajax_get_order_rewiev', 'get_order_rewiev' );
add_action( 'wp_ajax_nopriv_get_order_rewiev', 'get_order_rewiev' );
function get_order_rewiev() {
    ob_start();
    wc_get_template( 'checkout/review-order.php' );
    $html = ob_get_clean();
    wp_send_json_success(array( 'html' => $html ));
}


//add_action( 'woocommerce_order_status_changed', 'send_invoice_on_order_status_change', 10, 4 );
function send_invoice_on_order_status_change( $order_id, $old_status, $new_status, $order ) {

    if ('pending' === $new_status || 'processing' === $new_status)
    {
        if ($order->get_payment_method() === 'invoice')
        {
            $email = $order->get_billing_email();
            $subject = 'Your Invoice for Order ' . $order->get_order_number();
            $message = '';

            $invoice = wcpdf_get_document( 'invoice', $order_id, true );
            //$pdf_data = $invoice->get_pdf();
            // $pdf_data = $invoice->output_pdf();
            ob_start();
            $pdf_data = $invoice->get_pdf();
            ob_end_clean();

            $upload_dir = wp_upload_dir();
            $file_path = $upload_dir['basedir'] . '/invoices/order_' . $order_id . '_invoice.pdf';
            file_put_contents( $file_path, $pdf_data );

            wp_mail( $email, $subject, $message, array( 'Content-Type: text/html; charset=UTF-8' ), array( $file_path ) );
        }
    }

}



function custom_account_menu_items($items) {
    $items['my_invoice'] = 'Your invoice';

    // Переміщення "Моїй сторінки" на 3-тє місце
    $ordered_items = array();

    // Збереження перших двох елементів
    $ordered_items['dashboard'] = $items['dashboard'];
    $ordered_items['orders'] = $items['orders'];

    // Додавання нової сторінки на 3-тє місце
    $ordered_items['my_invoice'] = $items['my_invoice'];

    // Збереження решти елементів після нашої сторінки
    $ordered_items['downloads'] = $items['downloads'];
    $ordered_items['edit-address'] = $items['edit-address'];
    $ordered_items['payment-methods'] = $items['payment-methods'];

    $ordered_items['edit-account'] = $items['edit-account'];

    $ordered_items['account_info'] = $items['account_info'];

    $ordered_items['customer-logout'] = $items['customer-logout'];

    return $ordered_items;

}
add_filter('woocommerce_account_menu_items', 'custom_account_menu_items');

function custom_account_menu_endpoint() {
    add_rewrite_endpoint('my_invoice', EP_PAGES);
    add_rewrite_endpoint('account_info', EP_PAGES);
}
add_action('init', 'custom_account_menu_endpoint');

function custom_account_page_content() {
    $template_path = get_template_directory() . '/woocommerce/myaccount/my-invoice.php';

    if (file_exists($template_path)) {
        include($template_path);
    } else {
        echo 'Some text';
    }
}
add_action('woocommerce_account_my_invoice_endpoint', 'custom_account_page_content');

function account_info_page_content() {
    $template_path = get_template_directory() . '/woocommerce/myaccount/account_info.php';

    if (file_exists($template_path)) {
        include($template_path);
    } else {
        echo 'Some text';
    }
}
add_action('woocommerce_account_account_info_endpoint', 'account_info_page_content');

function custom_account_rewrite_flush() {
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'custom_account_rewrite_flush');


add_filter('woocommerce_checkout_fields', 'customize_shipping_checkout_fields');
function customize_shipping_checkout_fields($fields) {

    $fields['shipping']['shipping_country'] = array(
        'type'        => 'select',
        'label'       => __('Shipping Country', 'woocommerce'),
        'required'    => true,
        'class'       => array('form-row-wide'),
        'options'     => array('' => __('Select a country', 'woocommerce')) + WC()->countries->get_allowed_countries(),
    );

    $fields['shipping']['shipping_state'] = array(
        'type'        => 'select',
        'label'       => __('Shipping State/Province', 'woocommerce'),
        'required'    => true,
        'class'       => array('form-row-wide'),
        'options'     => array('' => __('Select a state', 'woocommerce')) + WC()->countries->get_states(WC()->customer->get_shipping_country()),
    );

    return $fields;
}


function set_default_shipping_first_name( $value, $input ) {
    $user_id = intval(get_current_user_id());

    if ($user_id)
    {
        $record = get_user_meta($user_id, 'shipping_field_saved', true);
        if ( is_array($record) )
        {
            // find default

            $default_data=[];

            foreach ($record as $info)
            {
                if ($info['set_default']==1)
                {
                    $default_data = $info;
                    break;
                }
            }

            if (count($default_data))
            {
                if ('shipping_first_name' === $input)
                {
                    $value = $default_data['shipping_first_name'];
                }

                if ('shipping_phone' === $input)
                {
                    $value = $default_data['shipping_phone'];
                }

                if ('shipping_address_1' === $input)
                {
                    $value = $default_data['shipping_address_1'];
                }
            }

        }

    }
    return $value;
}
add_filter( 'woocommerce_checkout_get_value', 'set_default_shipping_first_name', 10, 2 );


//------------------------------------------------



add_action('woocommerce_checkout_create_order', 'add_discount_to_order_meta', 10, 2);
function add_discount_to_order_meta($order, $data) {
    $total_quantity = 0;
    $discount_percentage = 0;
    $discount_total = 0;

    foreach ($order->get_items() as $item) {
        $total_quantity = $item->get_quantity();
        $product_price = $item->get_subtotal();

        if ($total_quantity >= 20) {
            $discount_percentage = 20;
        } elseif ($total_quantity >= 15) {
            $discount_percentage = 15;
        } elseif ($total_quantity >= 10) {
            $discount_percentage = 10;
        }

        if ($discount_percentage > 0) {
            $discount_total += $product_price * ($discount_percentage / 100);
        }
    }

    if ($discount_percentage > 0) {
        $order->add_meta_data(__('Quantity Discount Percentage', 'your-text-domain'), $discount_percentage . '%');
        $order->add_meta_data(__('Quantity Discount Total', 'your-text-domain'), $discount_total);
    }
}


function display_quantity_discount_cart() {
    $cart = WC()->cart;
    $total_quantity = $cart->get_cart_contents_count();
    $discount_percentage = 0;

    if ($total_quantity >= 20) {
        $discount_percentage = 20;
    } elseif ($total_quantity >= 15) {
        $discount_percentage = 15;
    } elseif ($total_quantity >= 10) {
        $discount_percentage = 10;
    }

    if ($discount_percentage > 0) {
        $discount = $cart->get_subtotal() * ($discount_percentage / 100);

        echo "
            <div class=\"wp-block-woocommerce-cart-order-summary-shipping-block wc-block-components-totals-wrapper\">
                <div class=\"wc-block-components-totals-item\">
                    <span class=\"wc-block-components-totals-item__label\">Quantity Discount</span>
                    <span class=\"wc-block-formatted-money-amount wc-block-components-formatted-money-amount\">".wc_price($discount)."	</span>
                </div>
            </div>
        ";
    }
}

add_action('woocommerce_admin_order_data_after_order_details', 'display_discount_in_admin');
function display_discount_in_admin($order) {
    $discount_percentage = $order->get_meta('Quantity Discount Percentage');
    $discount_total = $order->get_meta('Quantity Discount Total');

    if ($discount_percentage || $discount_total) {
        echo '<p><strong>' . __('Quantity Discount Percentage:', 'your-text-domain') . '</strong> ' . esc_html($discount_percentage) . '</p>';
        echo '<p><strong>' . __('Quantity Discount Total:', 'your-text-domain') . '</strong> ' . wc_price($discount_total) . '</p>';
    }
}


//------------ DISABLE WOOC. STYLES AND SCRIPT -------

//-------------------------------------------------

add_action('wp_enqueue_scripts', function () {
    if (!function_exists('is_woocommerce')) return;

    // 320 - ID login page, 326-register

    if (is_page(array(320,326))) {
        $handles = array(
            'woocommerce',
            'wc-add-to-cart',
            'wc-add-to-cart-variation',
            'wc-cart-fragments',
            'wc-single-product',
            'wc-checkout',
            'wc-blocks',
            'wc-blocks-style',
            'wc-blocks-vendors-style',
            'wc-blocks-checkout',
            'wc-blocks-product',
        );

        foreach ($handles as $h) {
            wp_dequeue_script($h);
            wp_deregister_script($h);
            wp_dequeue_style($h);
            wp_deregister_style($h);
        }

        global $wp_scripts, $wp_styles;

        if ($wp_scripts && isset($wp_scripts->queue)) {
            foreach ((array) $wp_scripts->queue as $h) {
                if (preg_match('/^(wc|woocommerce)/', $h)) {
                    wp_dequeue_script($h);
                    wp_deregister_script($h);
                }
            }
        }

        if ($wp_styles && isset($wp_styles->queue)) {
            foreach ((array) $wp_styles->queue as $h) {
                if (preg_match('/^(wc|woocommerce)/', $h)) {
                    wp_dequeue_style($h);
                    wp_deregister_style($h);
                }
            }
        }
    }
}, 999);

add_filter('woocommerce_add_to_cart_fragments', function($fragments){
    $fragments['count'] = WC()->cart->get_cart_contents_count();
    return $fragments;
});



