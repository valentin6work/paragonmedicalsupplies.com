<?php

add_action('wp_enqueue_scripts', 'fn_wp_enqueue_scripts');
function fn_wp_enqueue_scripts()
{
    global $template;

    wp_enqueue_script('jquery');

    wp_enqueue_style( theme_name.'-main', theme_url . '/css/main.min.css' );

    wp_enqueue_style( theme_name.'-dev-style', theme_url . '/css/dev.css' );


    wp_enqueue_script( theme_name.'-main.min', theme_url . '/js/main.min.js?t='.time(),NULL, NULL, true); // in footer
    wp_enqueue_script( theme_name.'-dev-js', theme_url . '/js/dev.js',NULL, NULL, true); // in footer


    $is_user_logged = is_user_logged_in();

    wp_localize_script( 'jquery', 'ajaxurl', array(
        'url' => admin_url('admin-ajax.php'),
    ) );

    wp_localize_script( 'jquery', 'theme_info', array(
        'is_login'=>$is_user_logged,
        'user_role'=>$is_user_logged?wp_get_current_user()->roles[0]:'false',
        'template_name'=>basename($template),
        'site_url'=>get_site_url(),
        'theme_url'=>get_template_directory_uri(),
        'comparison_url'=>get_permalink(400),
    ));
}



function fc_after_setup_theme()
{
    add_theme_support('woocommerce');

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
      * Let WordPress manage the document title.
      * This theme does not use a hard-coded <title> tag in the document head,
      * WordPress will provide it for us.
      */
    add_theme_support( 'title-tag' );

    // Remove feed icon link from legacy RSS widget.
    add_filter( 'rss_widget_feed_link', '__return_empty_string' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 450, 450 );


    add_image_size( 'slider-image', 1719, 599, true );

    add_image_size( 'blog-thumbnail', 775, 400, true );
    add_image_size( 'blog-small', 315, 220, true );

    if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
}
add_action( 'after_setup_theme', 'fc_after_setup_theme' );

add_filter( 'image_size_names_choose', 'custom_image_sizes_choose' );
function custom_image_sizes_choose( $sizes ) {
    $custom_sizes = array(
        'slider-image' => 'Slider Image',
        'blog-big' => 'Blog big',
        'blog-thumbnails' => 'Blog thumbnails',
    );
    return array_merge( $sizes, $custom_sizes );
}

function redirect_author_attachment() {
    if (!is_admin()) {
        if (is_author() || is_attachment()) {
            wp_redirect(home_url());
            exit();
        }
    }
}
add_action( 'template_redirect', 'redirect_author_attachment' );


function theme_init()
{
    register_nav_menu('menu', __('Menu'));
}
add_action( 'init', 'theme_init' );

add_filter( 'body_class', 'fn_wp_body_class' );
function fn_wp_body_class( $classes )
{
    global $template;

    $tmpls=[
        'front-page.php'=>'home',
        '404.php'=>'error404',
        'page.php'=>'page',
        'archive-blog.php'=>'blog',
        'single-blog.php'=>'blog',
        'taxonomy-blog_category.php'=>'blog',
        'taxonomy-blog_tags.php'=>'blog',
        'contact-page.php'=>'contact-page',
        'taxonomy-product_cat.php'=>'woocommerce-shop woocommerce woocommerce-page woocommerce-js',
        'login-page.php'=>'woocommerce-shop woocommerce woocommerce-page woocommerce-js',
        'register-page.php'=>'woocommerce-shop woocommerce woocommerce-page woocommerce-js',
        'forgot_pass-page.php'=>'woocommerce-shop woocommerce woocommerce-page woocommerce-js',
        'company_registration-page.php'=>'woocommerce woocommerce-page woocommerce-js select-style',
        'single-product.php'=>'product-template-default single single-product woocommerce woocommerce-page woocommerce-js',
        'wishlist-page.php'=>'woocommerce-shop woocommerce woocommerce-page woocommerce-js',
        'cart-page.php'=>'woocommerce-cart woocommerce-page woocommerce-js',
        'checkout-page.php'=>'woocommerce-checkout woocommerce-page woocommerce-js woocommerce-active',
        'my_account-page.php'=>'logged-in admin-bar woocommerce-account woocommerce-page woocommerce-js woocommerce-active',
        'new_password.php'=>'new-password-page woocommerce woocommerce-page woocommerce-js',
    ];


    $classes=[];
    if ( isset($tmpls[basename($template)]) )
    {
        $classes[]=$tmpls[basename($template)];
    }
    //$classes[]='home';


    if (is_user_logged_in()) {
        $classes[]='loged_in';
    }
    return $classes;
}


function redirect_uncategorized_category() {
    if (is_category('uncategorized') || is_author() || is_attachment()) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('template_redirect', 'redirect_uncategorized_category');

add_action('template_redirect', function () {
    $requested_url = $_SERVER['REQUEST_URI'];
    $lowercase_url = strtolower($requested_url);

    if ($requested_url !== $lowercase_url && !isset($_GET['key']) )
    {
        $redirect_url = home_url($lowercase_url);
        wp_redirect($redirect_url, 301);
        exit;
    }

    if (isset($_GET['s']))
    {
        $redirect_url = get_permalink(380).'/?search_word='.sanitize_text_field($_GET['s']);
        wp_redirect($redirect_url, 301);
        exit;
    }

    if (is_singular('post')) {
        global $wp_query;

        $wp_query->set_404();
        status_header(404);

        include get_template_directory() . '/404.php';
        exit;
    }

});


function get_image($image_field=[],$class='', $return=false)
{
    if ( isset($image_field['filesize']) && is_array($image_field) && count($image_field))
    {
        $classo = $class ? "class='$class' ":'';
        $alto = $image_field['alt'] ? " alt='$image_field[alt]' ":'';
        $title = $image_field['title'] ? " title='$image_field[title]' ":'';

        if ($return)
        {
            return "<img $classo src='$image_field[url]' $alto $title >";
        }
        ?>
            <img <?php echo $classo;?> src="<?php echo $image_field['url'];?>" <?php echo $alto;?> <?php echo $title;?> >
        <?php
    }
}


//------------ AJAX REQUEST ------------
add_action('wp_ajax_contact_form', 'contact_form');
add_action('wp_ajax_nopriv_contact_form', 'contact_form');
function contact_form()
{
    parse_str($_POST['formData'], $formData_output);

    if ( is_array($formData_output) && count($formData_output))
    {
        foreach ($formData_output as $key => $item)
        {
            $$key=$item;
        }
    }

    $name = validate_request($name,32);
    $company = validate_request($company,32);
    $email = validate_request($email,32);
    $phone = validate_request($phone,32);
    $message = validate_request($message,1024);


   if ( $name && $email && $message )
    {
        $form_setting = $_POST['form_setting'];
        $subject = sanitize_text_field($form_setting['subject']);
        $from_sender_email = sanitize_text_field($form_setting['sender_email']);

        $admin_email = get_option('admin_email');
        $site_name = get_bloginfo('name');
        $subject = $subject?$subject:'Contact form message';

        $from_email = $from_sender_email?$from_sender_email:$admin_email;

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: '.$site_name.' <'.$from_email.'>',
            'Reply-To: '.$site_name.' <'.$from_email.'>',
        );

        $message_html="
            <p><b>Name:</b> $name</p>
            <p><b>Company:</b> $company</p>
            <p><b>Email:</b> $email</p>
            <p><b>Phone:</b> $phone</p>
            <p><b>Message:</b> $message</p>
        ";

       // $admin_email = 'wbptest2022@yahoo.com';
        //$admin_email = 'tester@valentindev.isolly.com';

        $mail_sent = wp_mail($admin_email, $subject, $message_html, $headers);
        //$mail_sent2 = wp_mail('tester@valentindev.isolly.com', $subject, $message_html, $headers);
        if (!$mail_sent) {
            mail($admin_email, $subject, $message_html, implode("\r\n", $headers));
        }

        $error=0;
    }
    else
    {
        $error=1;
    }

    echo json_encode([
        'post'=>$_POST,
        '$headers'=>$headers,
        '$message_html'=>$message_html,
        'error'=>$error,
        'mail_sent'=>$mail_sent,
    ]);
    wp_die();
}
//------------ /AJAX REQUEST ------------

function validate_request($text, $maxLength=72) {
    $text = sanitize_text_field($text);
    $text = strip_tags($text);
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    if (mb_strlen($text) > $maxLength) {
        $text = mb_substr($text, 0, $maxLength,'UTF-8');
    }
    return $text;
}

class Custom_Menu_Walker extends Walker_Nav_Menu {
    // Overriding start_el method
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        // Check if the current item ID is 463
        if ($item->ID == 463) {
            // Adding custom class for styling
            $output .= '<li id="menu-item-'. $item->ID . '" class="menu-item menu-item-'. $item->ID .' menu-item-has-children ">';
            // Outputting menu item title without <a> tag
            $output .= $item->title;
        }
        else
        {
            // Adding custom class for styling and outputting menu item with <a> tag
            $output .= '<li id="menu-item-'. $item->ID . '" class="menu-item menu-item-'. $item->ID .'">';
            $output .= '<a href="' . $item->url . '">' . $item->title . '</a>';
        }
    }
}


function modify_search_query($query_vars) {
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $query_vars['s'] = sanitize_text_field($_GET['search']);
    }
    return $query_vars;
}
add_filter('request', 'modify_search_query');

//---------------------------------------------------------


function send_contact_form() {

    $first_name = sanitize_text_field($_POST['firstName']);
    $last_name = sanitize_text_field($_POST['lastName']);
    $contact_email = sanitize_email($_POST['contactEmail']);
    $contact_phone = sanitize_text_field($_POST['contactPhone']);
    $contact_subject = sanitize_text_field($_POST['contactSubject']);
    $contact_message = sanitize_textarea_field($_POST['contactMessage']);

    $to = get_option('admin_email');
    $to = 'tester@valentindev.isolly.com';
    $site_name = get_bloginfo('name');
    $subject = $site_name.' - contacts form message';

    $message = "
        <p><strong>Name:</strong> $first_name $last_name</p>
        <p><strong>Email:</strong> $contact_email</p>
        <p><strong>Phone:</strong> $contact_phone</p>
        <p><strong>Subject:</strong> $contact_subject</p>
        <p><strong>Message:</strong><br>$contact_message</p>
    ";

    $headers = array('Content-Type: text/html; charset=UTF-8');

    wp_mail($to, $subject, $message, $headers);

    wp_send_json_success('Message sent successfully.');

    wp_die();
}
add_action('wp_ajax_send_contact_form', 'send_contact_form');
add_action('wp_ajax_nopriv_send_contact_form', 'send_contact_form');


add_action('wp_ajax_custom_login', 'custom_login');
add_action('wp_ajax_nopriv_custom_login', 'custom_login');
function custom_login() {
    $creds = array();
    $creds['user_login'] = sanitize_email($_POST['loginEmail']);
    $creds['user_password'] = $_POST['password'];
    $creds['remember'] = isset($_POST['remember']) && $_POST['remember'] ? true : false;

    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        wp_send_json_error(array('message' => $user->get_error_message()));
        return;
    } else {
        wp_send_json_success();
    }

    wp_die();
}



add_action('wp_ajax_custom_user_registration', 'custom_user_registration');
add_action('wp_ajax_nopriv_custom_user_registration', 'custom_user_registration');
function custom_user_registration() {
    $username = sanitize_text_field($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = sanitize_text_field($_POST['password']);

    if (email_exists($email)) {
        wp_send_json_error(array('message' => 'User with this email already exists.'));
        return;
    }

    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        wp_send_json_error(array('message' => 'Registration failed. Please try again.'));
        return;
    }

    wp_send_json_success(array('message' => 'Registration successful!'));
}

add_action('wp_ajax_set_new_password', 'user_set_new_password');
add_action('wp_ajax_nopriv_set_new_password', 'user_set_new_password');
function user_set_new_password()
{
    if (is_user_logged_in())
    {
        $current_user_id = get_current_user_id();

        $password = sanitize_text_field($_POST['password']);
        $confPassword = sanitize_text_field($_POST['confPassword']);

        if ($password!=$confPassword)
        {
            wp_send_json_error(array('message' => 'Passwords do not match.'));
            return;
        }

        wp_set_password($password, $current_user_id);

        //wp_set_current_user($current_user_id);
        //wp_set_auth_cookie($current_user_id);

        wp_clear_auth_cookie();


        wp_send_json_success(array('message' => 'Password change successful!'));
    }
    else
    {
        wp_send_json_error(array('message' => 'Not authorization'));
    }
}

add_action('wp_ajax_forgot_password', 'handle_forgot_password');
add_action('wp_ajax_nopriv_forgot_password', 'handle_forgot_password');
function handle_forgot_password() {
    $email = sanitize_email($_POST['email']);

    if (!is_email($email) || !email_exists($email)) {
        wp_send_json_error(['message' => 'Invalid email address or not find.']);
        return;
    }

    $user = get_user_by('email', $email);
    $reset_key = get_password_reset_key($user);

    if (is_wp_error($reset_key)) {
        wp_send_json_error(['message' => 'Failed to generate reset link.']);
        return;
    }

    $reset_url = network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user->user_login));
    wp_mail($email, 'Password Reset', "Click this link to reset your password: $reset_url");

    wp_send_json_success(['message' => 'Password reset email sent.']);
}


add_action('wp_ajax_submit_company_form', 'submit_company_form');
add_action('wp_ajax_nopriv_submit_company_form', 'submit_company_form');
function submit_company_form() {



    $post_id = wp_insert_post([
        'post_type'   => 'company',
        'post_status' => 'publish',
        'post_title'  => sanitize_text_field($_POST['companyname']),
    ]);

    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => 'Failed to create company post.']);
        return;
    }

    foreach ($_POST as $field => $value) {
        update_field($field, sanitize_text_field($value), $post_id);
    }

    $admin_email = get_option('admin_email');
   // $admin_email = 'tester@valentindev.isolly.com';
    $edit_link = admin_url("post.php?post=$post_id&action=edit");
    wp_mail($admin_email, 'New Company Registration', "A new company has been registered. Edit here: $edit_link");

    wp_send_json_success();
}


add_action('save_post_company', 'create_user_on_company_approve', 10, 3);
function create_user_on_company_approve($post_id, $post, $update) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    $approved = get_field('approve', $post_id);

    if ($approved !== true) return;

    $email = get_field('compadminmail', $post_id);
    $first_name = get_field('firstnameadmin', $post_id);
    $last_name = get_field('lastnameadmin', $post_id);

    if (email_exists($email)) return;

    $password = wp_generate_password(12, false);

    $user_id = wp_create_user($email, $password, $email);

    if (is_wp_error($user_id)) {
        error_log("Failed to create user for post $post_id: " . $user_id->get_error_message());
        return;
    }

    if (!is_wp_error($user_id)) {
        wp_update_user([
            'ID' => $user_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'role' => 'company',
        ]);

        $subject = 'Welcome to the site!';
        $message = "Hello $first_name,\n\nYour account has been created.\n\nEmail: $email\nPassword: $password\n\nPlease log in and change your password.";
        wp_mail($email, $subject, $message);
    }
}

add_action('wp_ajax_get_wishlist', 'get_wishlist');
add_action('wp_ajax_nopriv_get_wishlist', 'get_wishlist');
function get_wishlist()
{
    $storedArray = $_POST['storedArray'];
    $prod_html='';
    if (is_array($storedArray) && count($storedArray))
    {
        foreach ($storedArray as $post_id)
        {
            set_query_var('product_id',$post_id);
            ob_start();
            get_template_part( 'theme_templates/global/products_item_wishlist');
            $prod_html.= ob_get_contents();
            ob_end_clean();
        }
    }
    echo json_encode([
        '$storedArray'=>$storedArray,
        'prod_html'=>$prod_html,
    ]);
    wp_die();
}


add_action('wp_ajax_comparison', 'get_comparison');
add_action('wp_ajax_nopriv_comparison', 'get_comparison');
function get_comparison()
{
    $compare_list = $_POST['compare_list'];
    $currency_symbol = get_woocommerce_currency_symbol();

    $prod_list=[];
    $prod_params_list=[];
    if ( is_array($compare_list) && count($compare_list))
    {
        $attribute_name = 'basic-price';

        $prod_head_html='<div class="product-comparison__row">';
        $bootom_add_cart='';
        foreach ($compare_list as $post_id)
        {
            $product = wc_get_product($post_id);
            $link = get_permalink($post_id);
            $main_image_id = $product->get_image_id();
            $main_image_url = $main_image_id ? wp_get_attachment_url($main_image_id) : wc_placeholder_img_src();
            $description =  $product->get_description() ? $product->get_description() : $product->get_short_description();
            $title = $product->get_name();

            $variations = $product->get_available_variations();
            $found_variation = null;

            if ($product->is_type('variable')) {
                $available_variations = $product->get_available_variations();
                $variation = $available_variations[0];
                $price = $variation['display_price'];
                $add_to_cart_url = '?add-to-cart=' . $variation['variation_id'];
            } else {
                $add_to_cart_url = '?add-to-cart=' . $product->get_id();
            }

            foreach ($variations as $variation) {
                $variation_obj = new WC_Product_Variation($variation['variation_id']);
                $attributes = $variation_obj->get_attributes();

                if ( $attributes['pa_count-by']==$attribute_name ) {
                    $found_variation = $variation_obj;
                    break;
                }
            }

            if ($found_variation)
            {
                $regular_price = $found_variation->get_regular_price();
                $sale_price = $found_variation->get_sale_price();
            }

            $prod_head_html.="
            <div class=\"product-comparison__col\">
                                            <div class=\"product\">
                                                <div class=\"product__properties\">
                                                    <span class=\"onsale status__cart-product\">Sale</span>
                                                    <div class=\"product__action\">
                                                        <div class=\"product__comparison active\" >
                                                            <img src=\"".theme_url."/img/comparison.svg\" alt=\"icon\">
                                                        </div>
                                                        <div class=\"remove_comparison\" data-prod_id='$post_id' >
                                                            <img src=\"".theme_url."/img/close-wishlist.svg\" alt=\"close\">
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href=\"$link\" class=\"woocommerce-Loop woocommerce-loop-product__link\">
                                                    <div class=\"product-image\">
                                                        <img class=\"woocommerce-placeholder wp-post-image\" src=\"$main_image_url\" alt=\"image\">
                                                    </div>
                                                    <div class=\"woocommerce-loop-product__title\">$title</div>
                                                </a>
                                                <div class=\"description__block\">
                                                    $description
                                                </div>
                                                <span class=\"price\">
                                        <span class=\"woocommerce-Price-amount amount\"><bdi><span class=\"woocommerce-Price-currencySymbol\">$currency_symbol</span>&nbsp;$regular_price</bdi></span>
                                    </span>
                                                <div class=\"wp-block-button product-add-to-cart\">
                                                    <a href=\"$add_to_cart_url\" class=\"button product_type_simple add_to_cart_button ajax_add_to_cart\"><img src=\"".theme_url."/img/cart-white.svg\" alt=\"cart\"><span>Add to Cart</span></a>
                                                </div>
                                            </div>
                                        </div>
            ";


            $products_params=get_field('products_params',$post_id)['list_params'];
            if (is_array($products_params) && count($products_params))
            {
                foreach ($products_params as $k=>$params)
                {
                    foreach ($compare_list as $post_id2)
                    {
                        if ($post_id==$post_id2)continue;
                        $p=get_field('products_params',$post_id2)['list_params'];
                        if (isset($p[$k]))
                        {
                            $val = $p[$k];
                            $prod_params_list[$params['name']][] = $val;
                        }
                        else
                        {
                            $prod_params_list[$params['name']][] = '-';
                        }
                    }
                }
            }

            $prod_list[]=[
                    'ID'=>$post_id,
                    'main_image_url'=>$main_image_url,
                    'title'=>$title,
                    'description'=>$description,
                    'regular_price'=>$regular_price,
                    'sale_price'=>$sale_price,
                    'currency_symbol'=>$currency_symbol,
                    'products_params'=>get_field('products_params',$post_id),
            ];

            $bootom_add_cart.="
             <div class=\"product-comparison__col\" id='comp_footer_$post_id' >
                    <div class=\"wp-block-button product-add-to-cart\">
                       <a href=\"$add_to_cart_url\" class=\"button product_type_simple add_to_cart_button ajax_add_to_cart\"><img src=\"".theme_url."/img/cart-white.svg\" alt=\"cart\"><span>Add to Cart</span></a>
                    </div>
                </div>
            ";
        }

        $prod_params_html='';
        if (is_array($prod_params_list) && count($prod_params_list))
        {
            foreach ($prod_params_list as $name=>$params)
            {
                $line='';

                if (is_array($params) && count($params))
                {
                    foreach ($params as $nm)
                    {
                        $line .= " <div class=\"product-comparison__col\">
                        <p>$nm[value]</p>
                    </div>";
                    }
                }

                $prod_params_html.="
                     <div class=\"product-comparison__row parameter__row\">
                        <div class=\"product-comparison__col-full\">
                            <p>$name</p>
                        </div>
                    </div>
                   <div class=\"product-comparison__row\">$line</div>
                ";
            }
        }

        $prod_head_html.='</div>'.$prod_params_html.'<div class="product-comparison__row">'.$bootom_add_cart.'</div>';

    }

    echo json_encode([
        '$_POST'=>$_POST,
        'prod_list'=>$prod_list,
        '$prod_params_list'=>$prod_params_list,
        'prod_head_html'=>$prod_head_html,
    ]);
    wp_die();
}


add_action('wp_logout', 'custom_redirect_after_logout');
function custom_redirect_after_logout() {
    wp_redirect(get_permalink(320));
    exit();
}


add_action('wp_login', 'track_daily_login', 10, 2);
function track_daily_login($user_login, $user) {
    $user_id = $user->ID;
    $current_date = current_time('Y-m-d'); //  'YYYY-MM-DD'

    $logins = get_user_meta($user_id, 'last_five_logins', true);

    if (!is_array($logins)) {
        $logins = [];
    }

    $found = false;
    foreach ($logins as $login) {
        if (substr($login['date'], 0, 10) === $current_date) {
            $found = true;
            break;
        }
    }

    if (!$found) {
        $logins[] = [
            'date'  => current_time('mysql'),
            'login' => $user_login,
        ];

        if (count($logins) > 5) {
            array_shift($logins);
        }

        update_user_meta($user_id, 'last_five_logins', $logins);
    }
}

function display_last_five_logins() {
    $user_id = get_current_user_id();
    $logins = get_user_meta($user_id, 'last_five_logins', true);

    if (empty($logins)) {
        return '';
    }

   // $first_name = get_user_meta($user_id, 'shipping_first_name', true);
   // $last_name = get_user_meta($user_id, 'shipping_last_name', true);

    $o='';
    foreach ($logins as $key=>$login) {
        $date = $login['date'];
        $login_name = $login['login'];

        $formatted_date = date('M j, Y, g:i A', strtotime($date));

        $user_info = get_user_by('login', $login_name);
        $full_name = $user_info ? $user_info->first_name . ' ' . $user_info->last_name : $login_name;


        $o.='<ul class="my-account-table-row">
                <li class="table-li-user-name">' . esc_html($login_name) . '</li>
                <li class="table-li-date">' . esc_html($formatted_date) . '</li>
                <li class="table-li-action">
                    <button class="remove-btn remove_last_logins" data-index="'.$key.'">
                        <img src="'.theme_url.'/img/close_filter_cell.svg" alt="icon">
                    </button>
                </li>
              </ul>';
    }


    return $o;
}


add_action('wp_ajax_remove_login_record', 'remove_login_record_function');
function remove_login_record_function() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'User not logged in.']);
        return;
    }

    $user_id = intval(get_current_user_id());
    $record_index = intval($_POST['record_index']);

    // Отримуємо існуючі записи про логіни
    $logins = get_user_meta($user_id, 'last_five_logins', true);

    if (empty($logins) || !isset($logins[$record_index])) {
        wp_send_json_error(['message' => 'Invalid login record or no records found.']);
        return;
    }

    unset($logins[$record_index]);

    $logins = array_values($logins);

    update_user_meta($user_id, 'last_five_logins', $logins);
    wp_send_json_success(['message' => 'Login record removed successfully.']);
}





add_action('wp_ajax_add_user_cart', 'add_user_cart');
function add_user_cart()
{
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'User not logged in.']);
        return;
    }

    $user_id = intval(get_current_user_id());

    $type_cart = $_POST['type_cart'];
    $cart_number = $_POST['cart_number'];
    $cart_expired = $_POST['cart_expired'];
    $set_cart_default = $_POST['set_cart_default'];


    $user_cart_list = get_user_meta($user_id, 'user_cart_list', true);

    if (!is_array($user_cart_list)) {
        $user_cart_list = [];
    }

    $user_cart_list[] = [
        'type_cart'  => $type_cart,
        'cart_number' => $cart_number,
        'cart_expired' => $cart_expired,
        'set_cart_default' => 0,
    ];

    update_user_meta($user_id, 'user_cart_list', $user_cart_list);

    wp_send_json_success(['message' => 'Cart adding successfully.','user_cart_list'=>$user_cart_list]);
}

add_action('wp_ajax_remove_cart', 'remove_cart');
function remove_cart()
{
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'User not logged in.']);
        return;
    }

    $user_id = intval(get_current_user_id());
    $indx = intval($_POST['indx']);

    $record = get_user_meta($user_id, 'user_cart_list', true);

    if (empty($record) || !isset($record[$indx])) {
        wp_send_json_error(['message' => 'Invalid record or no records found.']);
        return;
    }

    unset($record[$indx]);

    $record = array_values($record);

    update_user_meta($user_id, 'user_cart_list', $record);
    wp_send_json_success(['message' => 'Removed successfully.']);
}

add_action('wp_ajax_set_cart_deff', 'set_cart_deff');
function set_cart_deff()
{
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'User not logged in.']);
        return;
    }

    $user_id = intval(get_current_user_id());
    $indx = intval($_POST['indx']);

    $record = get_user_meta($user_id, 'user_cart_list', true);

    if (empty($record) || !isset($record[$indx])) {
        wp_send_json_error(['message' => 'Invalid record or no records found.']);
        return;
    }

    foreach ($record as $k=>$v)
    {
        $record[$k]['set_cart_default']=0;
    }

    $record[$indx]['set_cart_default']=1;

    $record = array_values($record);

    update_user_meta($user_id, 'user_cart_list', $record);
    wp_send_json_success(['message' => 'Set default successfully.']);
}


//--------------shipping------------------------
add_action('wp_ajax_add_shipping_field_custom', 'add_shipping_field_custom');
function add_shipping_field_custom()
{
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'User not logged in.']);
        return;
    }

    $user_id = intval(get_current_user_id());

    $shipping_first_name= sanitize_text_field($_POST['shipping_first_name']);
    $shipping_phone = sanitize_text_field($_POST['shipping_phone']);
    $shipping_address_1 = sanitize_text_field($_POST['shipping_address_1']);

    $shipping_is_edit = intval($_POST['shipping_is_edit']);
    $shipping_edit_idx = intval($_POST['shipping_edit_idx']);
    $set_default = intval($_POST['set_default']);

    if ($shipping_is_edit && $shipping_edit_idx>-1 ) // EDIT
    {
        $record = get_user_meta($user_id, 'shipping_field_saved', true);

        if (!is_array($record)) {
            $record = [];
        }

        if (isset($record[$shipping_edit_idx]))
        {
            $record[$shipping_edit_idx] = [
                'shipping_first_name' => $shipping_first_name,
                'shipping_phone' => $shipping_phone,
                'shipping_address_1' => $shipping_address_1,
                'set_default' => $set_default,
            ];
        }

        update_user_meta($user_id, 'shipping_field_saved', $record);

        wp_send_json_success(['message' => 'Edit successfully.', 'record' => $record]);
    }
    else
    {
        $record = get_user_meta($user_id, 'shipping_field_saved', true);

        if (!is_array($record)) {
            $record = [];
        }

        $record[] = [
            'shipping_first_name' => $shipping_first_name,
            'shipping_phone' => $shipping_phone,
            'shipping_address_1' => $shipping_address_1,
            'set_default' => 0,
        ];

        update_user_meta($user_id, 'shipping_field_saved', $record);

        wp_send_json_success(['message' => 'Adding successfully.', 'record' => $record]);
    }
}

add_action('wp_ajax_remove_shipping_address', 'remove_shipping_address');
function remove_shipping_address()
{
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'User not logged in.']);
        return;
    }

    $user_id = intval(get_current_user_id());
    $indx = intval($_POST['indx']);

    $record = get_user_meta($user_id, 'shipping_field_saved', true);

    if (empty($record) || !isset($record[$indx])) {
        wp_send_json_error(['message' => 'Invalid record or no records found.']);
        return;
    }

    unset($record[$indx]);

    $record = array_values($record);

    update_user_meta($user_id, 'shipping_field_saved', $record);
    wp_send_json_success(['message' => 'Removed successfully.']);
}

add_action('wp_ajax_set_ship_default', 'set_ship_default');
function set_ship_default()
{
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'User not logged in.']);
        return;
    }

    $user_id = intval(get_current_user_id());
    $indx = intval($_POST['indx']);

    $record = get_user_meta($user_id, 'shipping_field_saved', true);

    if (empty($record) || !isset($record[$indx])) {
        wp_send_json_error(['message' => 'Invalid record or no records found.']);
        return;
    }

    foreach ($record as $k=>$v)
    {
        $record[$k]['set_default']=0;
    }

    $record[$indx]['set_default']=1;

    $record = array_values($record);

    update_user_meta($user_id, 'shipping_field_saved', $record);
    wp_send_json_success(['message' => 'Set default successfully.','record'=>$record]);
}
//--------------/shipping------------------------

//---------- billing ----------------

add_action('wp_ajax_add_billing_field_custom', 'add_billing_field_custom');
function add_billing_field_custom()
{
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'User not logged in.']);
        return;
    }

    $user_id = intval(get_current_user_id());

    $billing_first_name= sanitize_text_field($_POST['billing_first_name']);
    $billing_phone = sanitize_text_field($_POST['billing_phone']);
    $billing_address_1 = sanitize_text_field($_POST['billing_address_1']);

    $billing_is_edit = intval($_POST['billing_is_edit']);
    $billing_edit_idx = intval($_POST['billing_edit_idx']);
    $set_default = intval($_POST['set_default']);

    if ($billing_is_edit && $billing_edit_idx>-1 ) // EDIT
    {
        $record = get_user_meta($user_id, 'billing_field_saved', true);

        if (!is_array($record)) {
            $record = [];
        }

        if (isset($record[$billing_edit_idx]))
        {
            $record[$billing_edit_idx] = [
                'billing_first_name' => $billing_first_name,
                'billing_phone' => $billing_phone,
                'billing_address_1' => $billing_address_1,
                'set_default' => $set_default,
            ];
        }

        update_user_meta($user_id, 'billing_field_saved', $record);

        wp_send_json_success(['message' => 'Edit successfully.', 'record' => $record]);
    }
    else
    {
        $record = get_user_meta($user_id, 'billing_field_saved', true);

        if (!is_array($record)) {
            $record = [];
        }

        $record[] = [
            'billing_first_name' => $billing_first_name,
            'billing_phone' => $billing_phone,
            'billing_address_1' => $billing_address_1,
            'set_default' => 0,
        ];

        update_user_meta($user_id, 'billing_field_saved', $record);

        wp_send_json_success(['message' => 'Adding successfully.', 'record' => $record]);
    }
}

add_action('wp_ajax_remove_billing_address', 'remove_billing_address');
function remove_billing_address()
{
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'User not logged in.']);
        return;
    }

    $user_id = intval(get_current_user_id());
    $indx = intval($_POST['indx']);

    $record = get_user_meta($user_id, 'billing_field_saved', true);

    if (empty($record) || !isset($record[$indx])) {
        wp_send_json_error(['message' => 'Invalid record or no records found.']);
        return;
    }

    unset($record[$indx]);

    $record = array_values($record);

    update_user_meta($user_id, 'billing_field_saved', $record);
    wp_send_json_success(['message' => 'Removed successfully.']);
}

add_action('wp_ajax_set_bill_default', 'set_bill_default');
function set_bill_default()
{
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'User not logged in.']);
        return;
    }

    $user_id = intval(get_current_user_id());
    $indx = intval($_POST['indx']);

    $record = get_user_meta($user_id, 'billing_field_saved', true);

    if (empty($record) || !isset($record[$indx])) {
        wp_send_json_error(['message' => 'Invalid record or no records found.']);
        return;
    }

    foreach ($record as $k=>$v)
    {
        $record[$k]['set_default']=0;
    }

    $record[$indx]['set_default']=1;

    $record = array_values($record);

    update_user_meta($user_id, 'billing_field_saved', $record);
    wp_send_json_success(['message' => 'Set default successfully.','record'=>$record]);
}

//---------- /billing ----------------
?>