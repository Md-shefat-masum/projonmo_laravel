$(function () {
    $('.triger_btn').on('click', function (e) {
        e.preventDefault();
        $('#side_nav').addClass('active')
    });

    $('#side_nav .overlay').on('click', function () {
        $('#side_nav').removeClass('active')
    });

    $('.filter_trigger').on('click', function (e) {
        e.preventDefault();
        $('#side_nav2').addClass('active')
    });

    $('#side_nav2 .overlay').on('click', function () {
        $('#side_nav2').removeClass('active')
    });

    setTimeout(() => {
        $('.next_prev a').on('click', function () {
            window.parent_section = $(this).parents('section');
            // $(window.parent_section[0]).find('.product_body').addClass('preloader');
        })

    }, 1000);

})

if (document.getElementById('ecommerce')) {

    // Vue.component('button-counter', {
    //     data: function () {
    //         return {
    //             count: 0
    //         }
    //     },
    //     template: '<button v-on:click="count++">You clicked me {{ count }} times.</button>'
    // })

    const app = new Vue({
        el: '#ecommerce',
        store: window.vue_store,
        data: function () {
            return {
                // auth_data
                auth_check: false,
                auth_info: {},

                latest_products: {},
                wanted_products: {},
                all_products: {},
                paginate: 5,
                all_product_paginate: 10,

                // get product json
                products: [],
                total: 0,
                lastPage: 0,
                perPage: 10,
                currentPage: 1,
                load: false,
                nextPageUrl: '',
                prevPageUrl: '',

                defaultUrlStart: '',
                defaultUrl: '',
                // get product json

                payment_method: {
                    name: 'bkash',
                    payment_method_number: '',
                    payment_method_transaction_id: '',
                },

                // product details pages data
                cart_qty: 1,
                show_btn: 'description',
                product_id: '',
                product_comments: [],
                product_info: {},

                // blog page data
                bloglist: {},

                reply_li: '',
                active_reply_comment_box: 0,

                show_search: false,
                search_products: [],
                search_writers: [],

            }
        },
        watch: {
            cart_qty: {
                handler: function (value) {
                    value <= 0 ? this.cart_qty = 1 : this.cart_qty = value;
                }
            }
        },
        created: function () {

            let width = $(window).width();
            if (width > 575 && width < 768) {
                this.paginate = 3;
                if (document.getElementById('latest_books')) {
                    this.get_latest_products();
                }
                if (document.getElementById('wanted_product')) {
                    this.get_wanted_products();
                }
            } else if (width < 576) {
                this.paginate = 2;
                if (document.getElementById('latest_books')) {
                    this.get_latest_products();
                }
                if (document.getElementById('wanted_product')) {
                    this.get_wanted_products();
                }
            } else {
                if (document.getElementById('latest_books')) {
                    this.get_latest_products();
                }
                if (document.getElementById('wanted_product')) {
                    this.get_wanted_products();
                }
            }

            if (document.getElementById('product_lists')) {
                // this.get_all_products();

                const params = new URLSearchParams(
                    window.location.search
                );
                let query_param = params.get("type");
                let main_category_id = null;
                let category_id = null;

                if (query_param && query_param == 'main_category') {
                    main_category_id = location.pathname.split('/')[3];
                }
                if (query_param && query_param == 'category') {
                    category_id = location.pathname.split('/')[4];
                }
                // console.log({main_category_id, category_id});
                if (category_id && parseInt(category_id) > 0) {
                    this.category_id = category_id;
                    this.defaultUrlStart = '/get-category-product';
                    this.make_default_url(this.category_id, 1);
                    this.get_products(this.defaultUrl);
                } else if (main_category_id && parseInt(main_category_id) > 0) {
                    this.category_id = main_category_id;
                    this.defaultUrlStart = '/get-main-category-product';
                    this.make_default_url(this.category_id, 1);
                    this.get_products(this.defaultUrl);
                } else {
                    this.defaultUrlStart = '/get-product';
                    this.make_default_url();
                    this.get_products(this.defaultUrl, 1);
                }
            }

            if( document.getElementById('offer_product_lists')){
                this.get_offer_products();
            }

            if( document.getElementById('writer_product_lists')){
                this.writer_product_lists();
            }

            if (document.getElementById('product_details_body')) {
                let id = location.pathname.split('/')[2];
                if (id) {
                    this.get_single_product(id);
                }
            }

            // reset cart
            this.set_delivery_charge(0);

            // get auth info
            axios.get('/auth-check').then(res => this.auth_check = res.data);
            axios.get('/auth-info').then(res => this.auth_info = res.data);

            // blog part
            if (document.getElementById('blog_list_section')) {
                this.get_blog_json();
            }

        },
        methods: {
            ...window.mapMutations([
                'set_carts',
                'remove_from_carts',
                'change_cart_qty',
                'set_delivery_charge',
                'reset_cart',
                'set_recent_views',
            ]),

            make_default_url: function (category_id, page_number) {
                if (page_number) {
                    this.currentPage = page_number;
                } else {
                    this.currentPage = 1;
                }
                if (category_id != undefined) {
                    // console.log({category_id});
                    this.defaultUrl = `${this.defaultUrlStart}/${this.category_id}/${this.perPage}/${this.currentPage}/json`;
                } else {
                    // console.log({category_id,currentPage:this.currentPage});
                    this.defaultUrl = `${this.defaultUrlStart}/${this.perPage}/${this.currentPage}/json`;
                }
            },
            get_widget_category_product: function (data, url_path, json_url) {
                const state = data;
                const title = '';
                let url = url_path;
                history.pushState(state, title, url);

                url = new URL(window.location);
                url.searchParams.set('type', data.type);
                window.history.pushState({}, '', url);

                this.defaultUrlStart = json_url;
                this.category_id = data.id;
                // console.log(data,json_url);
                this.make_default_url(data.id);
                this.get_products(this.defaultUrl);
            },
            get_paginate_product: function (page) {
                // console.log(page);

                if (this.category_id) {
                    this.make_default_url(this.category_id, page);
                } else {
                    this.make_default_url(undefined, page);
                }
                this.get_products(this.defaultUrl);
            },
            get_products: function (url) {
                // console.log(url.split('/')[1]);
                // this.defaultUrlStart = url.split('/')[1];
                // this.make_default_url(url.split('/')[2]);

                url.length > 0 &&
                    axios.get(url)
                    .then((res) => {
                        // console.log(res.data);
                        this.products = res.data.data;
                        this.total = res.data.total;
                        this.lastPage = res.data.lastPage;
                        this.perPage = res.data.perPage;
                        this.currentPage = res.data.currentPage;
                        this.nextPageUrl = res.data.nextPageUrl;
                        this.prevPageUrl = res.data.prevPageUrl;

                        this.all_products = res.data;

                        this.load = true;
                        if (res.data.data.length <= 4) {
                            $('.row').css('justify-content', 'unset')
                        }

                        $('html, body').animate({
                            scrollTop: 0
                        }, 'fast');

                        setTimeout(() => {
                            $('#wanted_product').height($('#wanted_product').height());
                            window.parent_section ? $(window.parent_section[0]).find('.product_body').removeClass('preloader') : $('.product_body').removeClass('preloader');
                        }, 2000);
                    })
            },

            get_offer_products: function(page=1){
                axios.get('/offer-products/json?page='+page)
                    .then((res)=>{
                        // console.log(res.data);
                        this.products = res.data.data;
                        this.all_products = res.data;
                    })

                $('html, body').animate({
                    scrollTop: 0
                }, 'fast');

                setTimeout(() => {
                    $('#offer_product_lists').height($('#offer_product_lists').height());
                    window.parent_section ? $(window.parent_section[0]).find('.product_body').removeClass('preloader') : $('.product_body').removeClass('preloader');
                }, 2000);
            },

            writer_product_lists: function(page=1){
                let slug = window.location.pathname.split('/')[2];
                axios.get(`/writer-products/${slug}/json?page=`+page)
                    .then((res)=>{
                        // console.log(res.data);
                        this.products = res.data.data;
                        this.all_products = res.data;
                    })

                $('html, body').animate({
                    scrollTop: 0
                }, 'fast');

                setTimeout(() => {
                    $('#writer_product_lists').height($('#writer_product_lists').height());
                    $('.product_body').removeClass('preloader');
                }, 2000);
            },

            get_single_product: function (id) {
                axios.get('/get-single-product/json/' + id)
                    .then((res) => {
                        // console.log(res.data);
                        let data = {
                            id: parseInt(id),
                            details: res.data,
                        }
                        this.set_recent_views(data);
                        this.product_info = res.data;
                    })
            },

            get_latest_products: function (page = 1) {
                $.get('/json/latest-products-json/' + this.paginate + '?page=' + page, (res) => {
                    this.latest_products = res;

                    setTimeout(() => {
                        // $('#latest_books').height($('#latest_books').height());
                        window.parent_section ? $(window.parent_section[0]).find('.product_body').removeClass('preloader') : $('.product_body').removeClass('preloader');
                    }, 2000);
                });
            },

            get_wanted_products: function (page = 1) {
                $.get('/json/wanted-products-json/' + this.paginate + '?page=' + page, (res) => {
                    // console.log(res);
                    this.wanted_products = res;
                    setTimeout(() => {
                        // $('#wanted_product').height($('#wanted_product').height());
                        window.parent_section ? $(window.parent_section[0]).find('.product_body').removeClass('preloader') : $('.product_body').removeClass('preloader');
                    }, 2000);
                });
            },

            add_to_cart: function (item) {
                console.log(item);
                let product_price = item.discount_price ? item.discount_price : item.price;
                let info = {
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    qty: this.cart_qty,
                    product_price,
                    product: item,
                };
                this.set_carts(info);
                toaster('success', 'book added to cart')
            },

            chech_delivery_method: function (method_name) {
                this.payment_method.name = method_name;
            },

            checkout_submit: function () {
                let form_data = new FormData($('#checkout_form')[0]);
                form_data.append('cart_product', JSON.stringify(this.get_carts));
                form_data.append('get_sub_total', JSON.stringify(this.get_sub_total));
                form_data.append('get_total', JSON.stringify(this.get_total));

                axios.post('/checkout-submit', form_data)
                    .then((res) => {
                        // console.log(res.data);
                        toaster('success', 'your order submitted');
                        this.reset_cart();
                        setTimeout(() => {
                            window.location.assign(location.origin + '/print-invoice?order=' + res.data.slug);
                        }, 1000);
                    })
                    .catch((err) => {
                        //
                        if (err.response.data.errors.cart_product && err.response.data.errors.cart_product[0]) {
                            console.log(err.response.data.errors.cart_product);
                            $('#cart_product').html('there is no product in cart. <a href="/products">go to product list.</a>')
                        }
                    })

            },

            store_subscriber: function () {
                let form_data = new FormData($('#subscription_form')[0]);
                axios.post('/store-subscriber', form_data)
                    .then((res) => {
                        toaster('success', 'Thanks for your subscription.');
                        $('#subscription_form').trigger('reset');
                        $('#subscription_form .text-danger').remove();
                    })
                    .catch((err) => {
                        toaster('error', err.response.data.errors.email[0]);
                    })
            },

            get_comments: function (page = 1) {
                axios.get(`/get-comments/${this.product_info.id}?page=` + page)
                    .then((res) => {
                        this.product_comments = res.data;
                    })
            },

            store_comment: function () {
                let form_data = new FormData($('#product_comment_form')[0]);
                form_data.append('product_id', this.product_info.id);

                axios.post('/store-comment', form_data)
                    .then((res) => {
                        $('.star').removeClass('selected');

                        $('#product_comment_form input').val('');
                        $('#product_comment_form textarea').val('');

                        this.product_comments.data.unshift(res.data);

                        this.get_single_product(this.product_info.id);
                        toaster('success', 'thanks for your valuable review');

                        $('#product_comment_form .text-danger').remove();
                    })
                    .catch((err) => {
                        toaster('error', 'fill the required area.')
                    })
            },

            change_show_btn: function (title) {
                this.show_btn = title;

                if (title == 'review') {
                    setTimeout(() => {
                        this.init_rating_jquery();
                        this.get_comments();
                    }, 500);
                }
            },
            init_rating_jquery: function () {
                $(".rating-component .star")
                    .on("mouseover", function () {
                        var onStar = parseInt($(this).data("value"), 10); //
                        $(this)
                            .parent()
                            .children("i.star")
                            .each(function (e) {
                                if (e < onStar) {
                                    $(this).addClass("hover");
                                } else {
                                    $(this).removeClass("hover");
                                }
                            });
                    })
                    .on("mouseout", function () {
                        $(this)
                            .parent()
                            .children("i.star")
                            .each(function (e) {
                                $(this).removeClass("hover");
                            });
                    });

                $(".rating-component .stars-box .star").on("click", function () {
                    var onStar = parseInt($(this).data("value"), 10);
                    var stars = $(this).parent().children("i.star");
                    var ratingMessage = $(this).data("message");

                    var msg = "";
                    var i = 0;
                    if (onStar > 1) {
                        msg = onStar;
                    } else {
                        msg = onStar;
                    }
                    $(".rating-component .starrate .ratevalue").val(msg);

                    for (i = 0; i < stars.length; i++) {
                        $(stars[i]).removeClass("selected");
                    }

                    for (i = 0; i < onStar; i++) {
                        $(stars[i]).addClass("selected");
                    }

                    $(".status-msg .rating_msg").val(ratingMessage);
                    $(".status-msg").html(ratingMessage);
                    $("[data-tag-set]").hide();
                    $("[data-tag-set=" + onStar + "]").show();
                });

            },
            auth_login: function () {
                let form_data = new FormData($('#login_form')[0]);
                axios.post('/auth-login', form_data)
                    .then((res) => {
                        this.auth_check = true;
                        this.auth_info = res.data;
                    })
            },

            get_blog_json: function (page = 1) {
                axios.get('/get-blogs-json?page=' + page)
                    .then((res) => {
                        this.bloglist = res.data;
                    })
            },

            user_registration: function () {
                let form_data = new FormData($("#registration_form")[0]);
                axios.post('/user-registration', form_data)
                    .then((res) => {
                        $("form .text-danger").remove();
                        // console.log(res.data);
                        location.assign(location.href);
                    })

            },

            store_blog_comment: function (e) {
                let form_data = new FormData($(e.target)[0]);
                axios.post('/store-blog-comment', form_data)
                    .then((res) => {
                        let data = res.data;

                        if (this.active_reply_comment_box) {
                            $(this.reply_li).children('ul').append(`
                                <div class="commentsp bg-secondary px-2">
                                    <div class="img">
                                        <img src="/avatar.png" alt="">
                                    </div>
                                    <div class="content">
                                        <h4><cite>${ data.name }</cite> <span>says:</span></h4>
                                        <p>${ data.description }</p>
                                        <p class="footer text-danger">
                                            your comment will show when authority will confirm.
                                        </p>
                                    </div>
                                </div>
                            `);
                            $(this.reply_li).children('.comment_body').toggleClass('d-none');
                        }else{
                            $('.comment-list').append(`
                                <li>
                                    <div class="commentsp bg-secondary px-2">
                                        <div class="img">
                                            <img src="/avatar.png" alt="">
                                        </div>
                                        <div class="content">
                                            <h4><cite>${ data.name }</cite> <span>says:</span></h4>
                                            <p>${ data.description }</p>
                                            <p class="footer text-danger">
                                                your comment will show when authority will confirm.
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            `)
                        }
                        $(e.target).trigger('reset');
                    })
            },

            show_reply: function (e) {
                // console.log(e.target);
                let li = $(e.target).parent('p').parent('div').parent('div').parent('li');
                this.reply_li = li;
                this.active_reply_comment_box = !this.active_reply_comment_box;
                $(li).children('.comment_body').toggleClass('d-none');

                if(this.active_reply_comment_box){
                    let form = $(li).children('.comment_body');
                    $(form[0]).find('input').trigger('focus');
                }
            },

            sumbit_contact:function(){
                let form_data = new FormData($('#contact_form')[0]);
                axios.post('/sumbit_contact',form_data)
                    .then((res)=>{
                        toaster('success','thanks for your valueable feedback.')
                        $('#contact_form').trigger('reset');
                    })
            },

            live_search: _.debounce(function(search_value){
                console.log(search_value);
                axios.post('/product/search/json',{key:search_value})
                    .then(res=>{
                        console.log(res.data);
                        this.search_products = res.data.products;
                        this.search_writers = res.data.writers;
                    })
            },1000),

        },
        computed: {
            ...window.mapGetters([
                'get_carts',
                'get_sub_total',
                'get_total',
                'get_billing_info',
                'get_recent_views',
            ]),
        }
    })

}


// get_all_products: function (page = 1) {
//     $.get('/json/latest-products-json/' + this.all_product_paginate + '?page=' + page, (res) => {
//         console.log(res);
//         this.all_products_2 = res;
//         setTimeout(() => {
//             $('#wanted_product').height($('#wanted_product').height());
//             window.parent_section ? $(window.parent_section[0]).find('.product_body').removeClass('preloader') : $('.product_body').removeClass('preloader');
//         }, 1000);
//     });
// },

// init_pagination: function () {
//     let that = this;
//     let dataSource = [];
//     for (let index = 1; index <= that.total; index++) {
//         dataSource.push(index);
//     }
//     console.log(that.total);
//     var container = $('#demo');
//     container.pagination({
//         dataSource: dataSource,
//         pageSize: 1,
//         showGoInput: true,
//         showGoButton: true,
//         callback: function (data, pagination) {
//             // console.log(data[0]);
//             that.currentPage = data[0]??1;
//             if(that.category_id != undefined){
//                 console.log(that.category_id);
//                 that.make_default_url(that.category_id);
//             }else{
//                 that.make_default_url();
//             }
//             // that.defaultUrl = `/get-category-product/${that.category_id}/${that.perPage}/${that.currentPage}/json`;
//             // that.get_products(that.defaultUrl);
//         },
//     });
// }
