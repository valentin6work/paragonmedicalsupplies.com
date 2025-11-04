<?php
/**
 * My Invoice - Custom
 *
 * @package WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

$per_page = 12;
$page = isset($_GET['invpage']) ? absint($_GET['invpage']) : 1;

$args = array(
    'status' => '',
    'limit' => $per_page,
    'page' => $page,
    'payment_method' => 'invoice',
    'customer_id' => get_current_user_id(),
);

$orders = wc_get_orders($args);

$total_orders = wc_get_orders(array(
    'status' => '',
    'payment_method' => 'invoice',
    'limit' => -1,
    'customer_id' => get_current_user_id(),
));
$total_pages = ceil(count($total_orders) / $per_page);



?>

<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->

<div class="my-account__wrap white-bg">
    <h1>Your Invoices</h1>
    <div class="my-account__table invoices-table">
        <ul class="my-account-table-row">
            <li class="table-li-number">Order</li>
            <li class="table-li-date">Date</li>
            <li class="table-li-status">Status</li>
            <li class="table-li-total">Total</li>
            <li class="table-li-action">Action</li>
        </ul>

        <?php
            if (!empty($orders))
            {
                foreach ($orders as $order)
                {
                    $currency_symbol = get_woocommerce_currency_symbol( $order->get_currency() );

                    $dt = esc_html( wc_format_datetime( $order->get_date_created() ) );
                    $_status='';

                    $total = $order->get_total();
                    $currency_symbol = get_woocommerce_currency_symbol( $order->get_currency() );
                    $formatted_total = number_format( $total, 2, '.', ',' );

                    switch ($order->get_status())
                    {
                        case 'on-hold':
                            $_status= "<span class=\"status-style processing\">On hold</span>";
                            break;
                        case 'completed':
                            $_status= "<span class=\"status-style completed\">COMPLETED</span>";
                            break;
                        case 'cancelled':
                            $_status= "<span class=\"status-style canceled\">CANCELLED</span>";
                            break;
                    }

                    echo "
                    <ul class=\"my-account-table-row\">
                        <li class=\"table-li-number\">INV".$order->get_id()."</li>
                        <li class=\"table-li-date\">$dt</li>
                        <li class=\"table-li-status\">$_status</li>
                        <li class=\"table-li-total\">$currency_symbol<span>$formatted_total</span></li>
                        <li class=\"table-li-action\">
                            <a href=\"". esc_url($order->get_view_order_url()) ."\">View</a>
                        </li>
                    </ul>
                    ";
                }
            }
        ?>

    </div>

    <?php

    if ($total_pages > 1) {
        echo '<nav class="pagination">';


        if ($page > 1) {
            echo '<a class="prev page-numbers" href="?invpage=' . ($page - 1) . '">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.42472 12.4915C3.9691 12.0359 3.9691 11.2972 4.42472 10.8416L8.26644 6.99992L4.42472 3.1582C3.9691 2.70262 3.9691 1.96389 4.42472 1.5083C4.88032 1.05266 5.61902 1.05266 6.07462 1.5083L10.7413 6.17497C11.1969 6.63055 11.1969 7.36929 10.7413 7.82487L6.07462 12.4915C5.61902 12.9472 4.88032 12.9472 4.42472 12.4915Z" fill="#0C89CD"/>
            </svg>
        </a>';
        } else {
            echo '<a class="prev page-numbers inactive" href="#">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.42472 12.4915C3.9691 12.0359 3.9691 11.2972 4.42472 10.8416L8.26644 6.99992L4.42472 3.1582C3.9691 2.70262 3.9691 1.96389 4.42472 1.5083C4.88032 1.05266 5.61902 1.05266 6.07462 1.5083L10.7413 6.17497C11.1969 6.63055 11.1969 7.36929 10.7413 7.82487L6.07462 12.4915C5.61902 12.9472 4.88032 12.9472 4.42472 12.4915Z" fill="#0C89CD"/>
            </svg>
        </a>';
        }


        echo '<ul class="page-numbers__list">';
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo '<li><a class="page-numbers current" href="#">' . $i . '</a></li>';
            } else {
                echo '<li><a class="page-numbers" href="?invpage=' . $i . '">' . $i . '</a></li>';
            }
        }
        echo '</ul>';

        if ($page < $total_pages) {
            echo '<a class="next page-numbers" href="?invpage=' . ($page + 1) . '">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.42472 12.4915C3.9691 12.0359 3.9691 11.2972 4.42472 10.8416L8.26644 6.99992L4.42472 3.1582C3.9691 2.70262 3.9691 1.96389 4.42472 1.5083C4.88032 1.05266 5.61902 1.05266 6.07462 1.5083L10.7413 6.17497C11.1969 6.63055 11.1969 7.36929 10.7413 7.82487L6.07462 12.4915C5.61902 12.9472 4.88032 12.9472 4.42472 12.4915Z" fill="#0C89CD"/>
            </svg>
        </a>';
        } else {
            echo '<a class="next page-numbers inactive" href="#">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.42472 12.4915C3.9691 12.0359 3.9691 11.2972 4.42472 10.8416L8.26644 6.99992L4.42472 3.1582C3.9691 2.70262 3.9691 1.96389 4.42472 1.5083C4.88032 1.05266 5.61902 1.05266 6.07462 1.5083L10.7413 6.17497C11.1969 6.63055 11.1969 7.36929 10.7413 7.82487L6.07462 12.4915C5.61902 12.9472 4.88032 12.9472 4.42472 12.4915Z" fill="#0C89CD"/>
            </svg>
        </a>';
        }

        echo '</nav>';
    }
    ?>

</div>

<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?> ] -->
