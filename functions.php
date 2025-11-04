<?php

define( 'theme_name', 'paragon' );
define( 'theme_url', get_template_directory_uri() );
define( 'theme_abs', get_template_directory() );
define( 'theme_domain', 'paragon' );

$included=[
    __DIR__.'/inc/inc_main_setting.php',
    __DIR__.'/inc/inc_woocomerce.php',
];

if ( is_array($included) && count($included))
{
    foreach ($included as $key => $item)
    {
        if ( file_exists($item))
        {
            include($item);
        }
    }
}

/*add_action( 'init', function() {
   update_option( 'admin_email', 'b.salkini@paragonmedicalsupplies.com' );
});*/

?>
