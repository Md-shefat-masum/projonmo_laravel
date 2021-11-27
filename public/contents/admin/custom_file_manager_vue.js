if (document.getElementById('create_product')) {
    const {
        default: store
    } = window.vue_store;

    const app = new Vue({
        el: '#fileManagerModal',
        store: store,
        data: function () {
            return {
                type_of_product: 'book',
                selected_file_input: '',
                selected_image: [],
                selected_image_id: [],
                images: {},
            }
        },
        created: function () {
            let that = this;
            $(window).on('load', function () {
                $('.input_file_body').on('click', function () {
                    that.get_all_image();
                    that.selected_file_input = $(this).children('input')[0];
                })

                $('#fm_confirm_btn').on('click', function (e) {
                    e.preventDefault();

                    if (that.selected_image.length) {
                        if ($(that.selected_file_input)[0].multiple === false) {
                            $(that.selected_file_input).val(that.selected_image[0]);
                            $(that.selected_file_input).siblings('img').attr('src', '/' + that.selected_image[0]);
                        } else {
                            // $(that.selected_file_input).val(JSON.stringify(selected_image));
                            $(that.selected_file_input).val(JSON.stringify(that.selected_image_id));
                            $(that.selected_file_input).siblings('img').remove();
                            for (let index = 0; index < that.selected_image.length; index++) {
                                const element = that.selected_image[index];
                                $(that.selected_file_input).parents('.input_file_body').prepend('<img src="/' + element + '" style="height: 50px;margin: 5px;" alt="product image"/>')
                            }
                        }
                        $('#fileManagerModal').modal('hide');
                    } else {
                        toaster('error', 'no file selected');
                    }
                });
            });
        },
        methods: {
            // ...window.mapMutations([
            //     'mapMutations',
            // ]),
            // ...window.mapActions([
            //     'mapActions',
            // ]),

            get_all_image: function (page = 1) {
                let that = this;
                $.get('/file-manager/get-files?page=' + page, (res) => {
                    console.log(res);
                    // $('.file_manager_image_list').html(res);
                    that.images = res;
                    that.activate_image_function();
                });
            },

            activate_image_function: function () {
                selected_image = [];
                selected_image_id = [];
                $('.fm_checkbox').on('click', function () {
                    let value = $(this).data('name');
                    let value_Id = $(this).val();
                    let check_exist = selected_image.includes(value);
                    if (check_exist) {
                        selected_image = selected_image.filter(name => name != value);
                        selected_image_id = selected_image_id.filter(id => id != value_Id);
                    } else {
                        selected_image.push(value);
                        selected_image_id.push(value_Id);
                    }
                    // console.log(value,selected_image);
                })
            },

            delete_file: function (event) {
                // console.log(event);
                let url = $(event.currentTarget).attr('href');
                let that = this;
                let confirm = window.confirm('sure want to delete!!');
                if (confirm) {

                    // axios.delete(location.origin + url, {
                    //     headers: {
                    //         Authorization: authorizationToken
                    //     },
                    //     data: {
                    //         source: ''
                    //     }
                    // });

                    $.ajax({
                        url: location.origin + url,
                        type: 'delete',
                        success: (res) => {
                            that.get_all_image();
                        }
                    })
                }
            },

            store_image: function (event) {

                let temp_form = $(document.createElement('form'));
                $(temp_form).attr('method', 'POST');
                $(temp_form).append($(event.target).clone());
                let formData = new FormData(temp_form[0]);
                let that = this;

                axios.post('/file-manager/store-file', formData)
                    .then((res) => {
                        $(event.target).val('');
                        that.get_all_image();
                        toaster('success', 'Image Uploaded Successfully');
                    })
            },

            select_image: function (event) {
                // console.log(event.target.value);
                let id = $(event.target).val();
                let name = $(event.target).data('name');

                if (this.selected_image.includes(name)) {
                    this.selected_image = this.selected_image.filter((item) => item != name);
                } else {
                    this.selected_image.push(name);
                }

                if (this.selected_image_id.includes(id)) {
                    this.selected_image_id = this.selected_image_id.filter((item) => item != id);
                } else {
                    this.selected_image_id.push(id);
                }
            }
        },

        computed: {
            // ...window.mapGetters(['get_selected_cart_all_product']),
        },
    });
}
