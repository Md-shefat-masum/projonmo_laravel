if (document.getElementById('category_form')) {
    const app = new Vue({
        el: '#category_form',
        // store: store,
        data: function () {
            return {
                category_serial: 0,
                form_data: {
                    id: null,
                    title: null,
                    url: null,
                    description: null,
                    parent_category: null,
                    template_layout_file: null,
                    sort_order: null,
                    default_product_sort: null,
                    category_image: null,
                    page_title: null,
                    meta_keywords: null,
                    meta_description: null,
                    search_keywords: null,
                },
                url_exists: false,
            }
        },
        created: function () {
            this.get_cateogry();
            this.init_category_tree_view();
            console.log(
                // this.$store.default.state,
                // this.$store.default.commit('test_mutation'),
                // this.$store.default.dispatch('fetch_auth_info'),

                // this.test_mutation(),
                // this.fetch_category_info(),
            );
        },
        methods: {
            // ...window.mutation(['test_mutation']),
            // ...window.action(['fetch_category_info']),
            get_cateogry: function () {
                if (location.pathname.split('/')[4] && parseInt(location.pathname.split('/')[4]) > 0) {
                    axios.get('/admin/blog/edit-data/' + location.pathname.split('/')[4])
                        .then((res) => {
                            this.form_data = res.data;
                            console.log(res.data);
                        })
                }
            },
            store: function () {
                let form_datas = new FormData($('#form_body')[0]);
                form_datas.append('description', $('#mytextarea1').summernote('code'));

                if (this.url_exists) {
                    toaster('error', 'url already exists.');
                    $(`input[name="url"]`).focus();
                } else {
                    axios.post('/admin/blog/store-category', form_datas)
                        .then((res) => {
                            // console.log(res.data);
                            $('#treeview').html(res.data.category_tree_view);
                            this.init_category_tree_view();
                            $('#form_body').trigger('reset')
                            $('#mytextarea1').summernote('reset');
                            $(`input[name="name"]`).focus();
                            toaster('success', 'new category created.');
                        })
                        .catch((err) => {
                            // console.log(err.response);
                            let errors = err.response.data.errors;
                            for (const key in errors) {
                                if (Object.hasOwnProperty.call(errors, key)) {
                                    const element = errors[key];
                                    $(`input[name="${key}"]`).addClass('border');
                                    $(`input[name="${key}"]`).addClass('border-danger');
                                    let span = `<span class="text-danger d-block">${element}</span>`;
                                    $(`input[name="${key}"]`).parent('div').append(span);
                                    $(`input[name="${key}"]`).focus();

                                    if (key == 'url') {
                                        toaster('error', 'url not valid');
                                    }
                                }
                            }
                        })
                }

            },
            update: function () {
                let form_datas = new FormData($('#form_body')[0]);
                form_datas.append('description', $('#mytextarea1').summernote('code'));

                if (this.url_exists) {
                    toaster('error', 'url already exists.');
                    $(`input[name="url"]`).focus();
                } else {
                    axios.post('/admin/blog/update-category', form_datas)
                        .then((res) => {
                            $('#treeview').html(res.data.category_tree_view);
                            this.init_category_tree_view();
                            toaster('success', 'Category Updated.');
                        })
                        .catch((err) => {
                            // console.log(err.response);
                            let errors = err.response.data.errors;
                            for (const key in errors) {
                                if (Object.hasOwnProperty.call(errors, key)) {
                                    const element = errors[key];
                                    $(`input[name="${key}"]`).addClass('border');
                                    $(`input[name="${key}"]`).addClass('border-danger');
                                    let span = `<span class="text-danger d-block">${element}</span>`;
                                    $(`input[name="${key}"]`).parent('div').append(span);
                                    $(`input[name="${key}"]`).focus();

                                    if (key == 'url') {
                                        toaster('error', 'url not valid');
                                    }
                                }
                            }
                        })
                }

            },
            check_url_exists: function (url) {
                axios.post('/admin/blog/categorie-url-check', {
                        url: url,
                        id: this.form_data.id
                    })
                    .then((res) => {
                        // console.log(res.data);
                        this.url_exists = res.data;
                        if (res.data) {
                            console.log(res);
                            $(`input[name="url"]`).addClass('border');
                            $(`input[name="url"]`).addClass('border-danger');
                            let span = `<span class="text-danger d-block">url exists , try another</span>`;
                            $(`input[name="url"]`).parent('div').children('span').remove();
                            $(`input[name="url"]`).parent('div').append(span);
                        } else {
                            $(`input[name="url"]`).removeClass('border');
                            $(`input[name="url"]`).removeClass('border-danger');
                            $(`input[name="url"]`).parent('div').children('span').remove();
                        }
                    })
            },
            make_url: function () {
                this.form_data.url = this.form_data.name;
                this.form_data.url = '/' + this.make_slug(this.form_data.url);
                this.check_url_exists(this.form_data.url);
            },
            change_url: function () {
                this.form_data.url = (this.form_data.url).replaceAll('/', '');
                this.form_data.url = '/' + this.make_slug(this.form_data.url);
                this.check_url_exists(this.form_data.url);
            },
            make_slug: function (str) {
                //replace all special characters | symbols with a space
                str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();

                // trim spaces at start and end of string
                str = str.replace(/^\s+|\s+$/gm, '');

                // replace space with dash/hyphen
                str = str.replace(/\s+/g, '-');
                return str;

            },
            init_category_tree_view: function () {
                setTimeout(() => {
                    $("#treeview").hummingbird();
                    $("#treeview li").off().on('click', function () {})
                    $("#treeview li input").off().on('click', function () {})
                    $("#treeview li label").off().on('click', function () {})
                }, 300);
            }
        },
        // computed: {
        //     ...window.getters(['get_check_auth']),
        // }
    });
}
