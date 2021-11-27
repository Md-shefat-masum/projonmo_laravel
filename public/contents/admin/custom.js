$(function () {

    // remover action on navbar dropdown menu
    $('.has-arrow').on('click', (e) => e.preventDefault());

    // rerender delete function on ajax load html
    const init_delete_function = () => {
        $('.delete_btn').off().on('click', function (e) {
            e.preventDefault();
            if (confirm('sure want to delete')) {
                $.ajax({
                    url: $(this).attr('href'),
                    type: 'delete',
                    success: (res) => {
                        $(this).parents($(this).data('parent')).remove();
                        $(this).parents('tr').remove();
                        $(this).parents('li').remove();
                        // Toast.fire({
                        //     icon: 'success',
                        //     title: 'data deleted'
                        // })
                    }
                })
            }
        });
    }

    init_delete_function();

    // remove alert on foucus input fields
    $('input').off().on('focus', function (e) {
        $(this).siblings('span').html('');
    });

    $('select').off().on('focus', function (e) {
        $(this).siblings('span').html('');
    });

    $('textarea').off().on('focus', function (e) {
        $(this).siblings('span').html('');
    });

    // all insert form ajax
    $('.insert_form').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData($(this)[0]);
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: (res) => {
                console.log(res);
                $(this).trigger('reset');
                $('.product_insert_form select').val('').trigger('change')
                $('.note-editable').html('');
                $('.preloader').hide();
                toaster('success', 'data inserted successfully.');
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

    // all update form ajax
    $('.update_form').on('submit', function (e) {
        e.preventDefault();
        let formData = new FormData($(this)[0]);
        formData.append('description',$('#mytextarea1').summernote('code'));
        // console.log($('#mytextarea1').summernote('code'),'ok')
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: (res) => {
                $('.preloader').hide();
                toaster('success', 'data updated successfully.');
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

    // product main category ajax
    $('.product_main_category').on('change', function () {
        let value = $(this).val();
        $.get('/admin/product/get-all-cateogory-selected-by-main-category/' + value, (res) => {
            $('.product_category').html(res);
            $('.product_sub_category').html('');
        });
    })

    // product category ajax
    $('.product_category').on('change', function () {
        let value = $(this).val();
        $.get('/admin/product/get-all-sub-cateogory-selected-by-category/' + value, (res) => {
            $('.product_sub_category').html(res);
        });
    })


})
