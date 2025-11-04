jQuery(document).ready(function(){

    function initializeProductDescriptions(container) {
        const products = $(container).find('.description-text__wrap .product');

        if (!products.length) return;

        products.each(function () {
            const productCard = $(this);
            const cardDescriptionBlock = productCard.find('.description__block p');
            const cardToggleButton = productCard.find('.toggle-btn');

            if (!cardDescriptionBlock[0] || !cardToggleButton[0]) return;

            const maxHeight = $(window).width() < 575 ? 82 : 105;

            if (cardDescriptionBlock[0].scrollHeight > maxHeight) {
                cardToggleButton.css('display', 'inline-block');
            } else {
                cardToggleButton.css('display', 'none');
                cardDescriptionBlock.removeClass('expanded');
                cardToggleButton.text('...');
            }

            cardToggleButton.off('click.toggleDescription');

            cardToggleButton.on('click.toggleDescription', function () {
                const isExpanded = cardDescriptionBlock.toggleClass('expanded').hasClass('expanded');
                cardToggleButton.text(isExpanded ? 'Hide' : '...');
                cardToggleButton.toggleClass('hide', isExpanded);
            });
        });
    }

    $(document).on('click', '.scroll-btn', function(event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $('#compare_content').offset().top - 150
        }, 1000);

        return false;
    });

    $('#fplus').on('click', function(e) {
        e.preventDefault();
        let input = $('#pcount');
        let currentVal = parseInt(input.val(), 10);
        if (!isNaN(currentVal)) {
            input.val(currentVal + 1);
        } else {
            input.val(1);
        }
    });

    $('#fminus').on('click', function(e) {
        e.preventDefault();
        let input = $('#pcount');
        let currentVal = parseInt(input.val(), 10);
        if (!isNaN(currentVal) && currentVal > 1) {
            input.val(currentVal - 1);
        } else {
            input.val(1);
        }
    });

    $('#product-form').on('submit', function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            url: ajaxurl.url,
            type: 'POST',
            data: formData + '&action=add_to_cart',
            success: function(response) {
                $(document.body).trigger('added_to_cart');
                $('.shopping-cart__quantity span').html(response.data.count);
                //window.location.reload();
            }
        });
    });

    var old_var_id=0;
    $(document).on('click','.wholesale-prices__item',function(e){
       e.preventDefault();

       $('.wholesale-prices__item').removeClass('active');
       $(this).addClass('active');

       let varid = $(this).data('varid');
       let sale = $(this).data('sale');
       let price = $(this).data('price');

       if (old_var_id==0)
       {
           old_var_id = parseInt($('#variation_id').val());
       }

        $('#variation_id').val(varid);

    });

    $(document).on('click','a.ajax_add_to_cart',function(e){
       e.preventDefault();
        let href = $(this).attr('href');
        let productId = href.match(/add-to-cart=(\d+)/)[1];

        $.ajax({
            url: '/?wc-ajax=add_to_cart',
            type: 'POST',
            data: {
                product_id: productId
            },
            success: function(response) {
                $(document.body).trigger('added_to_cart');
                $('.shopping-cart__quantity span').html(response.fragments['count']);
               // window.location.reload();

            },
            error: function() {
                console.error('error');
            }
        });

    });

    function show_form_error(msg='')
    {
        $('.form__error').html(msg).fadeIn(400);
        setTimeout(function() {
            $('.form__error').fadeOut(400);
        }, 12000);
    }

    function show_form_success(msg='')
    {
        $('.form__success').text(msg).fadeIn(400);
        setTimeout(function() {
            $('.form__success').fadeOut(400);
        }, 5000);
    }

    function hide_form_msg()
    {
        $('.form__success').text('').fadeOut(0);
        $('.form__error').text('').fadeOut(0);
    }

    $('.contact__form').on('submit', function(e) {
        e.preventDefault();

        var formData = {
            action: 'send_contact_form',
            firstName: $('#firstName').val(),
            lastName: $('#lastName').val(),
            contactEmail: $('#contactEmail').val(),
            contactPhone: $('#contactPhone').val(),
            contactSubject: $('#contactSubject').val(),
            contactMessage: $('#contactMessage').val(),
        };

        $.ajax({
            url: ajaxurl.url, // This should be localized via wp_localize_script in PHP
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('.form__success').text(response.data).fadeIn(400);
                    $('.contact__form')[0].reset();
                    setTimeout(function() {
                        $('.form__success').fadeOut(400);
                    }, 5000);
                } /*else {
                    $('.form__error').text('Помилка при відправці повідомлення.');
                }*/
            },
            error: function() {
                console.log('There was an error sending your message.');
            }
        });
    });

    $('#login_form').on('submit', function (e) {
        e.preventDefault();

        var loginData = {
            action: 'custom_login',
            loginEmail: $('input[name="loginEmail"]').val(),
            password: $('input[name="password"]').val(),
            remember: $('input[name="checkBox"]').is(':checked') ? true : false
        };

        $.ajax({
            url: ajaxurl.url, // URL AJAX
            type: 'POST',
            data: loginData,
            success: function (response) {
                if (response.success) {
                    window.location.href = '/';
                } else
                {
                    $('.form__error').html(response.data.message).fadeIn(400);
                    setTimeout(function() {
                        $('.form__error').fadeOut(400);
                    }, 12000);
                }
            },
            error: function (xhr, status, error) {
                console.log('Error');
            }
        });
    });

    $('.registration__form').on('submit', function(e) {
        e.preventDefault();

        let form = $(this),
            username = form.find('input[name="username"]').val(),
            email = form.find('input[name="registerEmail"]').val(),
            password = form.find('input[name="password"]').val(),
            confPassword = form.find('#confPassword').val(),
            checkBox = form.find('input[name="checkBox"]').is(':checked');


        hide_form_msg();

        if (!checkBox) {
            show_form_error('Please accept the Terms of agreement.');
            return;
        }

        if (password.length < 6) {
            show_form_error('Password must be at least 6 characters long.');
            return;
        }

        if (password !== confPassword) {
            show_form_error('Passwords do not match.');
            return;
        }

        $.ajax({
            url: ajaxurl.url,
            type: 'POST',
            data: {
                action: 'custom_user_registration',
                username: username,
                email: email,
                password: password
            },
            success: function(response) {
                if (response.success) {
                    show_form_success(response.data.message);
                    form[0].reset();

                } else {
                    show_form_error(response.data.message);
                }
            }
        });
    });



    $('#set_new_password').on('submit', function(e) {
        e.preventDefault();

        let form = $(this),
            password = form.find('input[name="password"]').val(),
            confPassword = form.find('#confPassword').val();

        hide_form_msg();

        if (password.length < 6) {
            show_form_error('Password must be at least 6 characters long.');
            return;
        }

        if (password !== confPassword) {
            show_form_error('Passwords do not match.');
            return;
        }

        $.ajax({
            url: ajaxurl.url,
            type: 'POST',
            data: {
                action: 'set_new_password',
                password: password,
                confPassword: confPassword
            },
            success: function(response) {
                if (response.success) {
                    show_form_success(response.data.message);
                    form[0].reset();

                    setTimeout(function () {
                        window.location.reload();
                    },2500);
                } else {
                    show_form_error(response.data.message);
                }
            }
        });
    });



    $('.forgot-password__form').on('submit', function(e) {
        e.preventDefault();
        const email = $('#forgotPasswEmail').val();

        $.post(ajaxurl.url, {
            action: 'forgot_password',
            email: email
        }).done(function(response) {
            if (response.success) {
                show_form_success(response.data.message);
                $('.forgot-password__form')[0].reset();
            } else {
                show_form_error(response.data.message);
            }
        }).fail(function() {
            show_form_error('Server error. Please try again.');
        });
    });

    $('.company-reg').on('submit', function (e) {
        e.preventDefault();

        //let formData = $(this).serialize();

        let formData = {};
        $(this).serializeArray().forEach(function (field) {
            formData[field.name.toLowerCase()] = field.value;
        });

        $.post(ajaxurl.url, formData, function (response) {
            if (response.success) {
                show_form_success('Form submitted successfully!');
                $('.company-reg')[0].reset();
            } else {
                show_form_error(response.data.message || 'Submission failed.');
            }
        });
    });

    //----------- wishlist ---------

    class Wishlist {
        constructor(storageKey = 'wishlist') {
            this.storageKey = storageKey;
        }
        saveArray(array) {
            localStorage.setItem(this.storageKey, JSON.stringify(array));
        }
        getArray() {
            const storedArray = localStorage.getItem(this.storageKey);
            return storedArray ? JSON.parse(storedArray) : [];
        }
        addElement(element) {
            let array = this.getArray();
            if (!array.includes(element)) {
                array.push(element);
                this.saveArray(array);
                $('.wishlist__quantity span').text(array.length);
            }
        }
        removeElement(element) {
            let array = this.getArray();
            array = array.filter(item => item !== element);
            this.saveArray(array);
            $('.wishlist__quantity span').text(array.length);
        }

        clear() {
            localStorage.removeItem(this.storageKey);
            window.location.reload();
        }

        showWishlist() {
            const array = this.getArray();
            return array;
        }
    }

    $(document).on('click','.product__add-wishlist, .product-page__wishlist',function(){
        let prod_id = parseInt($(this).data('prod_id'));
        const wishlist = new Wishlist();
        if ($(this).hasClass('active'))
        {
            wishlist.removeElement(prod_id);
            $(this).removeClass('active');
        }
        else {
            wishlist.addElement(prod_id);
            $(this).addClass('active');
        }
    });


    const observer = new MutationObserver((mutationsList) => {
        mutationsList.forEach((mutation) => {
            $(mutation.addedNodes).each(function() {
                const targetElements = $(this).is('.product__add-wishlist, .product-page__wishlist')
                    ? $(this)
                    : $(this).find('.product__add-wishlist, .product-page__wishlist');

                targetElements.each(function() {
                    checkDataAttribute(this);
                });
            });
        });
    });
    observer.observe(document.body, { childList: true, subtree: true });

    function checkDataAttribute(element) {
        const prod_id = $(element).data('prod_id');
        const wishlist = new Wishlist();
        const list = wishlist.getArray();
        if (prod_id && list.includes(prod_id)) {
            $(element).addClass('active');
        }
    }

    $('.product__add-wishlist, .product-page__wishlist').each(function() {
        checkDataAttribute($(this));
    });

    const wishlist = new Wishlist();
    const list = wishlist.getArray();
    $('.wishlist__quantity span').text(list.length);


    $(document).on('click','.product__remove-icon',function(){
        let prod_id = parseInt($(this).data('prod_id'));
        const wishlist = new Wishlist();
        wishlist.removeElement(prod_id);
        $(this).closest('.product').remove();
    });

    $(document).on('click','.remove_comparison',function(){
        let prod_id = parseInt($(this).data('prod_id'));
        const wishlist = new Wishlist();
        wishlist.removeElement(prod_id);
        $(this).closest('.product').remove();
    });

    $(document).on('click','.filter__title-cell-clear:not(.filter_clear)',function(){
        const wishlist = new Wishlist();
        if (confirm('Clear wishlist?')) {
            wishlist.clear();
            $('#list_wishlist').html('');
        }
    });

    $(document).on('click','.filter_item',function(){
       let term_name = $(this).data('term_name');
       let term_id = $(this).data('term_id');

       SelectedFilters(term_id, term_name);

       execute_filter();
    });

    var sel_min = 0;
    var sel_max = 0;
    var filter_page=1;
    var search_w='';

    if ($('#min-price').length)
    {
        var min = parseFloat($('#min-price').attr('min'));
        var max = parseFloat($('#max-price').attr('max'));

        var price_html='';

        $("#rangeSlider").ionRangeSlider({
            type: 'double',
             min: min,
             max: max,
             from: min,
             to: max,
            grid: false,
            hide_min_max: true,
            hide_from_to: true,
             onChange: function (data) {
               $("#min-price").val("$" + data.from);
               $("#max-price").val("$" + data.to);

                 sel_min = data.from;
                 sel_max = data.to;
            },
            onFinish: function (data) {
                let html =`<div class="filter__title-cell filter_price_range">
                    <span class="filter__title">$${data.from} - $${data.to}</span>
                    <img src="${theme_info.theme_url}/img/close_filter_cell.svg" alt="close">
                </div>`;

                price_html = html;
                if ( !$('#selected_filters .filter_price_range').length )
                {
                    $('#selected_filters').prepend(html);
                }
                else
                {
                    $('.filter_price_range').replaceWith(html);
                }

                let selected_filters_price= {'min':data.from,'max':data.to,'html':html};
                localStorage.setItem('selected_filters_price', JSON.stringify(selected_filters_price));
                execute_filter();
            }
        });

    }

    $('#filter_sorted').change(function () {
        execute_filter();
    });

    function execute_filter()
    {
        let result = {}; // Initialize an empty object

        result['price']={
            'min':sel_min,
            'max':sel_max,
        }
        result['taxonomy']={};
        result['category_id']=category_id;
        result['sorted']=$('#filter_sorted option:selected').val();
        result['page']=filter_page;
        result['s']=search_w;

        $('.filter_item.wd-active').each(function () {
            let term_name = $(this).data('term_name');
            let term_id = $(this).data('term_id');
            let tax = $(this).data('tax');


            if (!result.taxonomy[tax]) {
                result.taxonomy[tax] = [];
            }


            if (!result.taxonomy[tax].includes(term_id)) {
                result.taxonomy[tax].push(term_id);
            }

        });

        $.post(ajaxurl.url, {
            action: 'filter_products',
            filter: result
        }).done(function(response) {

            $('#prod_list').html(response.data.html);
            $('#filt_pagin').html(response.data.pag);

            response.data.counter_products.counters.forEach(item => {
                $('.filter_item[data-term_id="'+item.all_terms+'"]').closest('li').find('span').text(item.count);
            });


            initializeProductDescriptions(document);

        }).fail(function() {

        });


        console.log(result)
    }


    function remove_price_range()
    {
        min = parseFloat($('#min-price').attr('min'));
        max = parseFloat($('#max-price').attr('max'));

        $("#rangeSlider").data("ionRangeSlider").update({
            from: min,
            to: max
        });

        $("#min-price").val("$" + min);
        $("#max-price").val("$" + max);

        sel_min = 0;
        sel_max = 0;

        let selected_filters_price= {'min':min,'max':max,'html':''};
        localStorage.setItem('selected_filters_price', JSON.stringify(selected_filters_price));
    }

    $(document).on('click','.filter_price_range',function(){
        remove_price_range();
        $(this).remove();
    });

    $(document).on('click','.remove-filter',function(){
        let term_id = $(this).data('term_id');
        removeFilter(term_id);
    });

    $(document).on('click','.filter_clear',function(){
        let selected_filters=[];
        localStorage.setItem('selected_filters', JSON.stringify(selected_filters));
        remove_price_range();
        $('#selected_filters').html('');
        $('.filter_item').removeClass('wd-active');
        execute_filter();
    });

    $(document).on('click','.filter_pag',function(e){
        e.preventDefault();

        let page = $(this).data('page');
        filter_page = page;
        execute_filter();
    });

    $(document).on('click','#searxh',function(e){
        e.preventDefault();
        search_w = $('#search_w').val();
        $('#swd').text(search_w);
        execute_filter();
    });

    var url = window.location.href;
    if (url.includes("?search_word=")) {
        var params = new URLSearchParams(window.location.search);
        var searchWord = params.get("search_word");
        if (searchWord) {
            console.log("searchWord:", searchWord);
            search_w = searchWord;
            execute_filter();
        }
    }

    $('#search_w').on('keypress', function (event) {
        if (event.which === 13) {
            search_w = $('#search_w').val();
            $('#swd').text(search_w);
            execute_filter();
        }
    });

    function render_selected_filters()
    {
        let selected_filters = JSON.parse(localStorage.getItem('selected_filters')) || [];

        $('#selected_filters').html(selected_filters.map(filter => `
        <div class="filter__title-cell">
            <span class="filter__title">${filter.term_name}</span>
            <img data-term_id="${filter.term_id}" src="${theme_info.theme_url}/img/close_filter_cell.svg" alt="close" class="remove-filter" >
        </div>
    `).join(''));

        selected_filters.forEach(filter => {
            $('.filter_item[data-term_id="' + filter.term_id + '"]').addClass('wd-active');
        });

        let tselected_filters_price = JSON.parse(localStorage.getItem('selected_filters_price')) || {'min':min,'max':max,'html':''};
        if (tselected_filters_price.html!="")
        {
            price_html = tselected_filters_price.html;
            $('#selected_filters').append(tselected_filters_price.html);

            if ($("#rangeSlider").length) {
                $("#rangeSlider").data("ionRangeSlider").update({
                    from: tselected_filters_price.min,
                    to: tselected_filters_price.max
                });
            }

            sel_min = tselected_filters_price.min;
            sel_max = tselected_filters_price.max;

            $("#min-price").val("$" + tselected_filters_price.min);
            $("#max-price").val("$" + tselected_filters_price.max);
        }

        if ($('.filter__title-cell').length) {
            $('#selected_filters').append(`
            <div class="filter__title-cell filter__title-cell-clear filter_clear">
                <span class="filter__title">Reset All Filters</span>
                <img src="${theme_info.theme_url}/img/close_filter_cell.svg" alt="close">
            </div>
        `);
        }



    }
    render_selected_filters();

    function SelectedFilters(term_id=0,term_name='') {
        let selected_filters = JSON.parse(localStorage.getItem('selected_filters')) || [];

        if (!selected_filters.some(filter => filter.term_id === term_id)) {
            selected_filters.push({ term_id, term_name });
            localStorage.setItem('selected_filters', JSON.stringify(selected_filters));
        }
        else
        {
            removeFilter(term_id);
            selected_filters = JSON.parse(localStorage.getItem('selected_filters')) || [];
        }

        $('#selected_filters').html(selected_filters.map(filter => `
        <div class="filter__title-cell">
            <span class="filter__title">${filter.term_name}</span>
            <img data-term_id="${filter.term_id}" src="${theme_info.theme_url}/img/close_filter_cell.svg" alt="close" class="remove-filter" >
        </div>
    `).join(''));

        $('#selected_filters').append(price_html);

        if ($('.filter__title-cell').length) {
            $('#selected_filters').append(`
            <div class="filter__title-cell filter__title-cell-clear filter_clear">
                <span class="filter__title">Reset All Filters</span>
                <img src="${theme_info.theme_url}/img/close_filter_cell.svg" alt="close">
            </div>
        `);
        }
    }

    function removeFilter(term_id) {
        let selected_filters = JSON.parse(localStorage.getItem('selected_filters')) || [];
        selected_filters = selected_filters.filter(filter => filter.term_id !== term_id);
        localStorage.setItem('selected_filters', JSON.stringify(selected_filters));

        $('.filter_item[data-term_id="'+term_id+'"]').removeClass('wd-active');

        $('#selected_filters').html(selected_filters.map(filter => `
        <div class="filter__title-cell">
            <span class="filter__title">${filter.term_name}</span>
            <img data-term_id="${filter.term_id}" src="${theme_info.theme_url}/img/close_filter_cell.svg" alt="close" class="remove-filter">
        </div>
    `).join(''));

        $('#selected_filters').append(price_html);

        if ($('.filter__title-cell').length) {
            $('#selected_filters').append(`
            <div class="filter__title-cell filter__title-cell-clear filter_clear">
                <span class="filter__title">Reset All Filters</span>
                <img src="${theme_info.theme_url}/img/close_filter_cell.svg" alt="close">
            </div>
        `);
        }
    }

    $('#compare').click(function(e){
        e.preventDefault();

        let prod_id = $(this).data('prod_id');

        let compare = JSON.parse(localStorage.getItem('prod_compare')) || [];

        if (compare.length<=3)
        {
            if (compare.includes(prod_id)) {
                compare = compare.filter(id => id !== prod_id);
                $(this).removeClass('active');
            } else {
                compare.push(prod_id);
                $(this).addClass('active');

            }
            localStorage.setItem('prod_compare', JSON.stringify(compare));

            document.location.href = theme_info.comparison_url;
        }
        else
        {
            document.location.href = theme_info.comparison_url;
        }
    });

    $(document).on('click','.remove_comparison',function(){
        let prod_id = $(this).data('prod_id');
        let compare = JSON.parse(localStorage.getItem('prod_compare')) || [];

        if (compare.includes(prod_id)) {
            compare = compare.filter(id => id !== prod_id);
        }
        localStorage.setItem('prod_compare', JSON.stringify(compare));

        $('#comp_footer_'+prod_id).remove();

        location.reload();
    });


    $('.plus_change').on('click', function() {
        var quantityInput = $(this).closest('.wc-block-components-quantity-selector').find('input[type="number"]');
        var currentQuantity = parseInt(quantityInput.val());
        var cart_item_key = $(this).closest('tr').data('cart_item_key');

        if (!isNaN(currentQuantity)) {
            quantityInput.val(currentQuantity + 1).trigger('change');
            updateCartAjax(cart_item_key, currentQuantity + 1);
        }
    });
    $('.minus_change').on('click', function() {
        var quantityInput = $(this).closest('.wc-block-components-quantity-selector').find('input[type="number"]');
        var cart_item_key = $(this).closest('tr').data('cart_item_key');
        var currentQuantity = parseInt(quantityInput.val());

        if (!isNaN(currentQuantity) && currentQuantity > 1) {
            quantityInput.val(currentQuantity - 1).trigger('change');
            updateCartAjax(cart_item_key, currentQuantity - 1);
        }
    });

    $('.wc-block-components-quantity-selector__input').on('keypress', function (event) {
        if (event.which === 13) {
            event.preventDefault();
            let currentQuantity = parseInt($(this).val());
            let cart_item_key = $(this).closest('tr').data('cart_item_key');

            if (!isNaN(currentQuantity) && currentQuantity > 1) {
                updateCartAjax(cart_item_key, currentQuantity);
            }
        }
    });

    function updateCartAjax(cartItemKey, newQuantity) {
        $.ajax({
            url: ajaxurl.url, // URL
            method: 'POST',
            data: {
                action: 'custom_update_cart',
                cart_item_key: cartItemKey,
                new_quantity: newQuantity,
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    console.error(response.data);
                }
            },
            error: function() {
                console.error('Не вдалося оновити кошик.');
            }
        });
    }



    try {
        var wcFormCheckout = document.getElementById('wc_form_checkout');
        if (wcFormCheckout) {
            var wcObserver = new MutationObserver(function (mutationsList) {
                mutationsList.forEach(function (mutation) {
                    if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {

                        if ($('.woocommerce-NoticeGroup').length > 0) {
                            $('.woocommerce-NoticeGroup').insertBefore('#wc_form_checkout');
                        }
                    }
                });
            });
            var config = {childList: true, subtree: true};
            wcObserver.observe(wcFormCheckout, config);
        }
    }catch (e) {
        console.log(e)
    }


    $('#shipping_method').change(function() {
        let selectedShippingMethod = $(this).val();

        if (selectedShippingMethod)
        {
            $( document.body ).trigger( 'update_checkout' );


            $.ajax({
                url: wc_checkout_params.ajax_url, // AJAX URL WooCommerce
                method: 'POST',
                async:false,
                data: {
                    action: 'update_shipping_method',
                    shipping_method: selectedShippingMethod,
                },
                success: function(response) {
                    $( document.body ).trigger( 'updated_checkout' );
                }
            });
        }
    });

    jQuery('body').on('updated_checkout', function(){
        console.log('updated_checkout triggered');

        $.ajax({
            url: wc_checkout_params.ajax_url, // AJAX URL WooCommerce
            method: 'POST',
           // async:false,
            data: {
                action: 'get_order_rewiev',
            },
            success: function(response) {
                $('#order_review').html(response.data.html);
            }
        });
    });


    $('.remove_last_logins').on('click', function(e) {
        e.preventDefault();

        if (!confirm('Delete record?'))
        {
            return false;
        }

        let recordIndex = $(this).data('index');
        let _this = $(this);
        $.ajax({
            url: ajaxurl.url,
            type: 'POST',
            data: {
                action: 'remove_login_record',
                record_index: recordIndex
            },
            success: function(response) {
                if(response.success) {
                    _this.closest('.my-account-table-row').remove();
                }
            },
            error: function() {
                 console.log('There was an error processing the request.');
            }
        });
    });


    //--------------------------------------

    function validateCardNumber(cardNumber) {
        if (!/^\d+$/.test(cardNumber)) {
            return false;
        }

        if (/^4\d{15}$/.test(cardNumber)) {
            return true;
        } else if (/^5[1-5]\d{14}$/.test(cardNumber)) {
            return true;
        }
        return false;
    }

    $('#add_new_card').click(function (e) {
        e.preventDefault();

        let type_cart = $('#type_cart').val();
        let cart_number = $('#cart_number').val(); // 4111112014267661
        let cart_expired = $('#cart_expired').val();
        let set_cart_default = $('#set_cart_default').prop('checked') ? 1 : 0;

        let vcart = validateCardNumber(cart_number);
        if (!vcart || cart_number.length<16 || cart_number=="" )
        {
            alert('Cart number error');
            return false;
        }

        if (cart_expired=="" )
        {
            alert('Cart expired error');
            return false;
        }

        $.ajax({
            url: ajaxurl.url,
            type: 'POST',
            data: {
                action: 'add_user_cart',
                type_cart: type_cart,
                cart_number: cart_number,
                cart_expired: cart_expired,
                set_cart_default: set_cart_default,
            },
            success: function(response) {
                if(response.success) {

                }
                window.location.reload();
            },
            error: function() {
                console.log('There was an error processing the request.');
            }
        });
    });

    $('.delete_cart').on('click', function(e) {
        e.preventDefault();

        if (!confirm('Delete cart?'))
        {
            return false;
        }

        let indx = $(this).data('indx');
        let _this = $(this);
        $.ajax({
            url: ajaxurl.url,
            type: 'POST',
            data: {
                action: 'remove_cart',
                indx: indx
            },
            success: function(response) {
                if(response.success) {
                    _this.closest('.shipping-and-shipping__block-row').remove();
                }
                window.location.reload();
            },
            error: function() {
                console.log('There was an error processing the request.');
            }
        });
    });

    $('.set_cart_default').on('click', function(e) {
        e.preventDefault();

        if (!confirm('Set cart default?'))
        {
            return false;
        }

        let indx = $(this).data('indx');
        let _this = $(this);
        $.ajax({
            url: ajaxurl.url,
            type: 'POST',
            data: {
                action: 'set_cart_deff',
                indx: indx
            },
            success: function(response) {
                if(response.success) {

                }
                window.location.reload();
            },
            error: function() {
                console.log('There was an error processing the request.');
            }
        });
    });


    var shipping_def=0;
    var billing_def=0;

    //-------------- shipping_field -------------------

    $('#btn_add_shipping_field_cust').click(function (e){
        e.preventDefault();

        let shipping_first_name = $('#shipping_first_name').val();
        let shipping_phone = $('#shipping_phone').val();
        let shipping_address_1 = $('#shipping_address_1').val();

        let shipping_is_edit = $('#shipping_is_edit').val();
        let shipping_edit_idx = $('#shipping_edit_idx').val();


        if ( shipping_first_name=="" || shipping_phone=="" || shipping_address_1==""  )
        {
            alert('All fields must be filled');
            return false;
        }

        $.ajax({
            url: ajaxurl.url,
            type: 'POST',
            data: {
                action: 'add_shipping_field_custom',
                shipping_first_name: shipping_first_name,
                shipping_phone: shipping_phone,
                shipping_address_1: shipping_address_1,
                shipping_is_edit: shipping_is_edit,
                shipping_edit_idx: shipping_edit_idx,
                set_default: shipping_def,
            },
            success: function(response) {
                if(response.success) {

                }
                window.location.reload();
            },
            error: function() {
                console.log('There was an error processing the request.');
            }
        });
    });

    $('.remove_shipping_address').on('click', function(e) {
        e.preventDefault();

        if (!confirm('Delete?'))
        {
            return false;
        }

        let indx = $(this).data('indx');
        let _this = $(this);
        $.ajax({
            url: ajaxurl.url,
            type: 'POST',
            data: {
                action: 'remove_shipping_address',
                indx: indx
            },
            success: function(response) {
                if(response.success) {
                    _this.closest('.shipping-and-shipping__block-row').remove();
                }
                window.location.reload();
            },
            error: function() {
                console.log('There was an error processing the request.');
            }
        });
    });

    $('.set_ship_default').on('click', function(e) {
        e.preventDefault();

        if (!confirm('Set default?'))
        {
            return false;
        }

        let indx = $(this).data('indx');
        let _this = $(this);
        $.ajax({
            url: ajaxurl.url,
            type: 'POST',
            data: {
                action: 'set_ship_default',
                indx: indx
            },
            success: function(response) {
                if(response.success) {

                }
                window.location.reload();
            },
            error: function() {
                console.log('There was an error processing the request.');
            }
        });
    });

    $('.edit_shipp_addr').on('click', function(e) {
        e.preventDefault();

        let shipping_first_name = $(this).data('shipping_first_name');
        let shipping_phone = $(this).data('shipping_phone');
        let shipping_address_1 = $(this).data('shipping_address_1');

        shipping_def = $(this).data('set_default');

        let indx = $(this).data('indx');

        $('#shipping_is_edit').val(1);
        $('#shipping_edit_idx').val(indx);

        $('#shipping_first_name').val(shipping_first_name);
        $('#shipping_phone').val(shipping_phone);
        $('#shipping_address_1').val(shipping_address_1);


        $('#btn_add_shipping_field_cust').text('Save address');
    });

    //-------------- /shipping_field -------------------

    //-------------- billing_field -------------------

    $('#btn_add_billing_field_cust').click(function (e){
        e.preventDefault();

        let billing_first_name = $('#billing_first_name').val();
        let billing_phone = $('#billing_phone').val();
        let billing_address_1 = $('#billing_address_1').val();

        let billing_is_edit = $('#billing_is_edit').val();
        let billing_edit_idx = $('#billing_edit_idx').val();

        if ( billing_first_name=="" || billing_phone=="" || billing_address_1==""  )
        {
            alert('All fields must be filled');
            return false;
        }

        $.ajax({
            url: ajaxurl.url,
            type: 'POST',
            data: {
                action: 'add_billing_field_custom',
                billing_first_name: billing_first_name,
                billing_phone: billing_phone,
                billing_address_1: billing_address_1,
                billing_is_edit: billing_is_edit,
                billing_edit_idx: billing_edit_idx,
                set_default: billing_def,
            },
            success: function(response) {
                if(response.success) {

                }
                window.location.reload();
            },
            error: function() {
                console.log('There was an error processing the request.');
            }
        });
    });

    $('.remove_billing_address').on('click', function(e) {
        e.preventDefault();

        if (!confirm('Delete?'))
        {
            return false;
        }

        let indx = $(this).data('indx');
        let _this = $(this);
        $.ajax({
            url: ajaxurl.url,
            type: 'POST',
            data: {
                action: 'remove_billing_address',
                indx: indx
            },
            success: function(response) {
                if(response.success) {
                    _this.closest('.billing-and-billing__block-row').remove();
                }
                window.location.reload();
            },
            error: function() {
                console.log('There was an error processing the request.');
            }
        });
    });

    $('.set_bill_default').on('click', function(e) {
        e.preventDefault();

        if (!confirm('Set default?'))
        {
            return false;
        }

        let indx = $(this).data('indx');
        let _this = $(this);
        $.ajax({
            url: ajaxurl.url,
            type: 'POST',
            data: {
                action: 'set_bill_default',
                indx: indx
            },
            success: function(response) {
                if(response.success) {

                }
                window.location.reload();
            },
            error: function() {
                console.log('There was an error processing the request.');
            }
        });
    });

    $('.edit_billing_addr').on('click', function(e) {
        e.preventDefault();

        let billing_first_name = $(this).data('billing_first_name');
        let billing_phone = $(this).data('billing_phone');
        let billing_address_1 = $(this).data('billing_address_1');

        billing_def = $(this).data('set_default');

        let indx = $(this).data('indx');

        $('#billing_is_edit').val(1);
        $('#billing_edit_idx').val(indx);

        $('#billing_first_name').val(billing_first_name);
        $('#billing_phone').val(billing_phone);
        $('#billing_address_1').val(billing_address_1);


        $('#btn_add_billing_field_cust').text('Save address');
    });
    //-------------- /billing_field ------------------
});
