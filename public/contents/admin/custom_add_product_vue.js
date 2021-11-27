const {
    default: store
} = window.vue_store;


if (document.getElementById('create_product')) {

    const app = new Vue({
        el: '#create_product',
        store: store,
        data: function () {
            return {
                type_of_product: 'book',
                id: '',
            }
        },
        created: function () {
            let that = this;
            $(window).on('load', function () {
                that.init_plugins();
                that.init_select2();
            });
            if(document.getElementById('edit_form')){
                this.id = location.pathname.split('/')[4];
                // this.get_product(this.id);
            }
        },
        methods: {
            // ...window.mapMutations([
            //     'mapMutations',
            // ]),
            // ...window.mapActions([
            //     'mapActions',
            // ]),

            // get_product: function(id){
            //     axios.get(`/admin/product/${id}/json`)
            //         .then((res)=>{
            //             console.log(res.data);
            //         })
            // },

            init_select2: function () {
                $('.multiple-select').select2({
                    placeholder: $(this).data('placeholder'),
                    allowClear: Boolean($(this).data('allow-clear')),
                }).on('change', function (e) {
                    // console.log(e);
                    if ((e.target.value && e.target.value > 0) || (e.target.value && e.target.value.length > 0)) {
                        $('#' + e.target.id + " option[value = " + e.target.value + "]").prop("selected", true);
                    }
                });
            },

            init_plugins: function () {

                $('#mytextarea1').off().summernote({
                    height: 400,
                    tabsize: 2
                });

                $('#mytextarea2').off().summernote({
                    height: 400,
                    tabsize: 2
                });

                // $('#selectmain_category_id').on('change', function () {
                //     let value = $(this).val();
                //     $.get("/admin/product/get-all-cateogory-selected-by-main-category/" + value, (res) => {
                //         $('#selectcategory_id').html(res);
                //         $('#selectproduct_category_id').trigger('change');
                //     });
                //     // $(this).val(value).trigger('change');
                // });

                // remove alert on foucus input fields
                $('input').on('focus', function (e) {
                    $(this).siblings('span').html('');
                });

                $('select').on('focus', function (e) {
                    $(this).siblings('span').html('');
                });

                $('textarea').on('focus', function (e) {
                    $(this).siblings('span').html('');
                });

                // all insert form ajax
                $('.product_insert_form').off().on('submit', function (e) {
                    e.preventDefault();
                    // e.stopPropagation();
                    let formData = new FormData($(this)[0]);
                    // let formData = new FormData(e.target);
                    // axios.post($(this).attr('action'), formData)
                    //     .then((res) => {
                    //         console.log(res.data);
                    //         $(this).trigger('reset');
                    //         $('.product_insert_form select').val('').trigger('change')
                    //         $('.note-editable').html('');
                    //         $('.preloader').hide();
                    //         toaster('success', 'data inserted successfully.');
                    //         setTimeout(() => {
                    //             window.location.reload();
                    //         }, 1000);
                    //     })
                    //     .catch((err) => {
                    //         console.log(err.response.data.errors);
                    //         let errors = err.response.data.errors;
                    //         for (const key in errors) {
                    //             if (Object.hasOwnProperty.call(errors, key)) {
                    //                 const element = errors[key];
                    //                 $(`.${key}`).text(element);
                    //             }
                    //         }
                    //         toaster('error', 'check below for errors');
                    //         $('.preloader').hide();
                    //     })

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        success: (res) => {
                            // console.log(res);
                            $(this).trigger('reset');
                            $('.product_insert_form select').val('').trigger('change')
                            $('.note-editable').html('');
                            $('.preloader').hide();
                            toaster('success', 'data stored successfully.');
                            setTimeout(() => {
                                window.location.reload()
                            }, 1000);
                        },
                        error: (err) => {
                            // console.log(err.responseJSON.errors);
                            let errors = err.responseJSON.errors;
                            for (const key in errors) {
                                if (Object.hasOwnProperty.call(errors, key)) {
                                    const element = errors[key];
                                    $(`.${key}`).text(element);
                                }
                            }
                            toaster('error', 'check below for errors');
                            $('.preloader').hide();
                        },
                        beforeSend: () => {
                            $('.preloader').show();
                        }
                    })
                });

                // component form ajax
                $('.component_form_submit').off().on('click', function () {
                    let form = $(this).parents('.component_form');
                    let target_select = $(this).parents('.component_form').data('target_select');
                    let action = $(this).parents('.component_form').attr('action');
                    let inputs = $(form[0]).children('.modal-body').children('.form-group').children('div').children('input');
                    let textareas = $(form[0]).children('.modal-body').children('.form-group').children('div').children('textarea');
                    let selects = $(form[0]).children('.modal-body').children('.form-group').children('div').children('.select_ontime').children('select');

                    // let formData = new FormData(form);
                    let temp_form = $(document.createElement('form'));
                    $(temp_form).attr('method', 'POST');

                    for (const key in inputs) {
                        if (Object.hasOwnProperty.call(inputs, key)) {
                            const element = inputs[key];
                            if (parseInt(key) >= 0 && typeof parseInt(key) === "number") {
                                $(temp_form).append($(element).clone());
                            }
                        }
                    }

                    for (const key in textareas) {
                        if (Object.hasOwnProperty.call(textareas, key)) {
                            const element = textareas[key];
                            if (parseInt(key) >= 0 && typeof parseInt(key) === "number") {
                                $(temp_form).append($(element).clone());
                            }
                        }
                    }

                    for (const key in selects) {
                        if (Object.hasOwnProperty.call(selects, key)) {
                            const element = selects[key];
                            if (parseInt(key) >= 0 && typeof parseInt(key) === "number") {
                                $(temp_form).append($(element).clone());
                            }
                        }
                    }

                    let formData = new FormData(temp_form[0]);

                    $.ajax({
                        url: action,
                        type: "POST",
                        data: formData,
                        success: (res) => {
                            // console.log(res.html,action);
                            $('.component_preloader').hide();
                            toaster('success', 'data inserted successfully.');
                            $('.modal').modal('hide');
                            $('.component_form input').val('');
                            $('.component_form textarea').val('');
                            $('.component_form select').html('');
                            $(target_select).prepend(res.html);
                            $(target_select).val(res.value);
                        },
                        error: (err) => {
                            // console.log(err.responseJSON.errors);
                            let errors = err.responseJSON.errors;
                            for (const key in errors) {
                                if (Object.hasOwnProperty.call(errors, key)) {
                                    const element = errors[key];
                                    $(`.component_form .${key}`).text(element);
                                }
                            }
                            toaster('error', 'check below for errors');
                            $('.component_preloader').hide();
                        },
                        beforeSend: () => {
                            $('.component_preloader').show();
                        }
                    })

                    // console.log(form, action, inputs, textareas, temp_form);
                });

                // if another select option change on one select
                $('.parent_select').off().on('change', function () {
                    let value = $(this).val();
                    let control_url = $(this).data('this_field_control_route');
                    let control_class = $(this).data('this_field_will_contorl');

                    $.get(control_url + '/' + value, (res) => {
                        $('.' + control_class).html(res);
                    })
                })

                // load option form modal component select
                $('.load_options').off().on('click', function (e) {
                    e.preventDefault();
                    let url = $(this).data('url');
                    let control_class = $(this).siblings('select').data('this_field_will_contorl');
                    $.get(url, (res) => {
                        $(this).siblings('select').html(res);
                        $(this).siblings('select').trigger('change');
                        if (control_class) {
                            $('.' + control_class).html('');
                        }
                    });
                });

                // product main category ajax
                $('.product_main_category').off().on('change', function () {
                    let value = $(this).val();
                    if (value && value > 0) {
                        $.get('/admin/product/get-all-cateogory-selected-by-main-category/' + value, (res) => {
                            $('.product_category').html(res);
                            $('.product_sub_category').html('');
                            if (res) {
                                $('.product_category').trigger('change');
                            }
                        });
                    }
                })

                // product category ajax
                $('.product_category').off().on('change', function () {
                    let value = $(this).val();
                    if (value && value > 0) {
                        $.get('/admin/product/get-all-sub-cateogory-selected-by-category/' + value, (res) => {
                            $('.product_sub_category').html(res);
                        });
                    }
                })
            },

            on_type_of_product_change: function (event) {
                this.type_of_product = event.target.value;
                $('.preloader').show();
                setTimeout(() => {
                    this.init_plugins();
                    this.init_select2();
                    $('.preloader').hide();
                }, 300);
            }
        },

        computed: {
            // ...window.mapGetters(['get_selected_cart_all_product']),
        },
    });
}
