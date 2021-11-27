// const {
//     default: store
// } = window.store;

// console.log(store);

if (document.getElementById('blog')) {
    const app = new Vue({
        el: '#blog',
        // store: store,
        data: function () {
            return {
                form_data: {
                    id: null,
                    title: null,
                    url: null,
                    description: '',
                    short_description: '',
                    category_list: '',
                    image:'',

                    seo_title: null,
                    seo_keywords: null,
                    seo_description: null,
                    search_keywords: null,
                },
                url_exists: false,

                categories: [],
                selected_categories: [],
                related_categories: [],

                category_html: '',

            }
        },
        created: function () {
            this.get_categories_tree_json();
            // this.get_shared_variant_options();
            // this.get_all_brands();

            if (location.pathname.split('/')[4] && parseInt(location.pathname.split('/')[4]) > 0) {
                this.id = parseInt(location.pathname.split('/')[4]);
                this.get_product(this.id);
            }

            let that = this;
            $(function () {
                $('#upload_image').on('change', function () {
                    $('.gallery').html('');
                    that.imagesPreview(this, 'div.gallery');
                });
            })
        },
        updated: function () {},
        watch: {},
        methods: {
            // ...window.action([
            //     'fetch_category_info',
            // ]),
            get_product: function (id) {
                axios.get('/admin/blog/get-json/' + id)
                    .then((res) => {
                        // console.log(res.data);
                        let product = res.data;
                        for (const key in product) {
                            if (Object.hasOwnProperty.call(product, key)) {
                                const element = product[key];

                                if (Object.hasOwnProperty.call(this.$data.form_data, key)) {
                                    if (key == 'category_list') {
                                        console.log(key);
                                        this.$data.selected_categories = JSON.parse(element);
                                    } else if (key == 'description') {
                                        $('#mytextarea1').summernote('code', element)
                                    } else {
                                        this.$data.form_data[key] = element;
                                    }
                                }
                            }


                        }
                        // console.log(this.$data);
                        setTimeout(() => {

                            let category_checkbox = $(`.category_block input[type="checkbox"]`);
                            let categories = this.selected_categories;

                            for (let index = 0; index < category_checkbox.length; index++) {
                                const element = category_checkbox[index];
                                if (typeof element == 'object') {
                                    if (element.type == 'checkbox' && categories.includes(parseInt(element.value))) {
                                        $(element).parents('ul').css('display', 'block');
                                        element.checked = true;
                                    }
                                }
                            }
                            this.draw_left_line();
                        }, 2000);
                    })
            },

            store_product: function () {
                let form_data = new FormData($('#blog_form')[0]);
                form_data.append('description', $('#mytextarea1').summernote('code'));
                form_data.append('selected_categories', JSON.stringify(this.selected_categories));

                axios.post('/admin/blog/store', form_data)
                    .then((res) => {
                        // console.log(res.data);
                        toaster('success', 'data Inserted');
                        // window.location.reload();
                    })
                    .catch((err) => {
                        toaster('error', 'please try again.');
                        if (err.response.data.errorInfo.length > 0) {
                            console.log(err.response.data.errorInfo);
                        }
                    })
            },

            update_product: function () {
                let form_data = new FormData($('#blog_form')[0]);
                form_data.append('id', this.form_data.id);
                form_data.append('description', $('#mytextarea1').summernote('code'));
                form_data.append('selected_categories', JSON.stringify(this.selected_categories));

                axios.post('/admin/blog/update', form_data)
                    .then((res) => {
                        // console.log(res.data);
                        toaster('success', 'data updated');
                        window.location.reload();
                    })
                    .catch((err) => {
                        toaster('error', 'please try again.');
                        console.log(err.response.data);
                    })
            },

            imagesPreview: function (input, placeToInsertImagePreview) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function (event) {
                            $($.parseHTML('<img style="height: 80px;margin:2px;border:1px solid white;padding:2px;border-radius:3px;">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }

            },

            get_categories_tree_json: function () {
                axios.get('/admin/blog/categories_tree_json')
                    .then((res) => {
                        // console.log(res.data);
                        this.categories = res.data;
                        this.array_depth(this.categories);

                        setTimeout(() => {
                            this.add_new_form_action();
                            $('.category_card_dropdown .card-body ul li ul').css('display', 'none');
                        }, 300);
                    })
            },

            array_depth: function (arr) {
                // console.log(arr);
                if (arr.length > 0) {
                    // this.category_html += `<ul style="${arr[0].parent == null ? 'display:block;' : 'display:none;'}">`;
                    this.category_html += `<ul>`;
                    this.category_html += '<span class="left_line"></span>';

                    for (let index = 0; index < arr.length; index++) {
                        const element = arr[index];
                        this.category_html += '<li>';
                        this.category_html += `
                            <div class="element">
                                <input type="checkbox" value="${element.id}" class="form-control">
                                <i class="fa fa-folder"></i>
                                <div>${element.name}</div>
                                <div data-id="${element.id}" class="add_sub_category">
                                    <a href="#">
                                        <i class="fa fa-plus"></i> Add sub-category
                                    </a>
                                </div>
                        `;
                        if (element.child !== undefined) {
                            this.category_html += `<div class="parent_element_trigger ${element.child.length > 0 ? ' d-block ' : ' d-none '}">
                                                        <i data-action="expand" class="fa fa-plus show_plus"></i>
                                                        <i data-action="collapse" class="fa fa-minus hide_plus"></i>
                                                    </div>`;
                        }

                        this.category_html += `</div>`;

                        if (element.child !== undefined) {
                            this.array_depth(element.child);
                        }

                        this.category_html += '</li>';
                    }

                    this.category_html += '</ul>';
                }
            },

            add_new_form_action: function () {
                let that = this;
                $('.add_sub_category').off().on('click', function () {
                    let ul = $(this).parent('div').parent('li').children('ul');
                    let sibling_element_trigger = $(this).siblings('.parent_element_trigger');
                    let id = $(this).data('id');

                    let element_2_ul_li_length = $('.element2').parent('li').parent('ul').children('li').length;
                    if (element_2_ul_li_length == 1) {
                        $('.element2').parent('li').parent('ul').remove();
                    } else {
                        $('.element2').parent('li').remove();
                        $('.element2').remove();
                    }

                    if (ul.length > 0) {
                        $(ul).css('display', 'block');
                        // console.log(sibling_element_trigger);
                        $(sibling_element_trigger).children('.fa-plus').removeClass('show_plus')
                        $(sibling_element_trigger).children('.fa-plus').addClass('hide_plus')

                        $(sibling_element_trigger).children('.fa-minus').removeClass('hide_plus')
                        $(sibling_element_trigger).children('.fa-minus').addClass('show_plus')

                        if (!$('.element2')[0]) {
                            let li = `<li>
                                        <div class="element element2">
                                            <div class="new_category_form_body">
                                                <input data-id="${id}" id="new_category_input_value" class="form-control new_category_form"/>
                                                <span class="d-none text-danger alert_box">Please provide a name</span>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-outline-danger cancel_element_2">Cancel</button>
                                                <button class="btn btn-info" id="new_cateogry_input_submit">Done</button>
                                            </div>
                                        </div>
                                    </li>`;
                            $(ul).append(li);
                            that.init_cancel_element_2();
                            that.init_new_cateogry_input_submit();
                            $('#new_category_input_value').focus();
                        } else {
                            $('#new_category_input_value').focus();
                        }
                    } else {
                        let li = $(this).parent('div').parent('li');
                        if (!$('.element2')[0]) {
                            let ul = `<ul>
                                        <span class="left_line"></span>
                                        <li>
                                            <div class="element element2">
                                                <div class="new_category_form_body">
                                                    <input data-id="${id}" id="new_category_input_value" class="form-control new_category_form"/>
                                                    <span class="d-none text-danger alert_box">Please provide a name</span>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-outline-danger cancel_element_2" data-remove_with="ul">Cancel</button>
                                                    <button class="btn btn-info" id="new_cateogry_input_submit">Done</button>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>`;
                            $(li).append(ul);
                            that.init_cancel_element_2();
                            that.init_new_cateogry_input_submit();
                            $('#new_category_input_value').focus();
                        } else {
                            $('#new_category_input_value').focus()
                        }
                    }

                    that.draw_left_line();
                    // console.log(ul);
                });

                $('.parent_element_trigger i').off().on('click', function () {
                    let action = $(this).data('action');
                    let target = $(this).parent('div').parent('div').parent('li').children('ul');

                    if (action == 'collapse') {
                        $(target).hide();
                        $(this).siblings('.fa-plus').addClass('show_plus');
                        $(this).siblings('.fa-plus').removeClass('hide_plus');
                        $(this).removeClass('show_plus');
                        $(this).addClass('hide_plus');
                        that.draw_left_line();
                    }

                    if (action == 'expand') {
                        $(target).show();
                        $(this).siblings('.fa-minus').addClass('show_plus');
                        $(this).siblings('.fa-minus').removeClass('hide_plus');
                        $(this).removeClass('show_plus');
                        $(this).addClass('hide_plus');
                        that.draw_left_line();
                    }
                    // console.log(action);
                });

                $(".category_block input[type=checkbox]").on('change', function () {
                    that.selected_categories = [];
                    $(".category_block input[type=checkbox]:checked").each(function () {
                        that.selected_categories.push(parseInt($(this).val()));
                    });
                })

                that.draw_left_line();
            },

            draw_left_line: function () {
                let uls = $('.category_card_dropdown ul');
                for (let index = 0; index < uls.length; index++) {
                    const element = uls[index];
                    let height = 0;
                    for (let index1 = 1; index1 < $(element)[0].children.length - 1; index1++) {
                        const element2 = element.children[index1];
                        height += $(element2).height();
                    }
                    // console.log(height);
                    $(element).children('.left_line').css('height', height + 48)
                }
            },

            init_cancel_element_2: function () {
                let that = this;
                $('.cancel_element_2').off().on('click', function (e) {
                    e.preventDefault();
                    let target = $(this).data('remove_with');

                    if (target == 'ul') {
                        $(this).parent('div').parent('.element2').parent('li').parent('ul').remove();
                    } else {
                        $(this).parent('div').parent('.element2').parent('li').remove();
                    }
                    that.draw_left_line();
                })
            },

            init_new_cateogry_input_submit: function () {
                let that = this;

                $('#new_cateogry_input_submit').off().on('click', function (e) {
                    e.preventDefault();
                    let parent_id = $('#new_category_input_value').data('id');
                    let name = $('#new_category_input_value').val();
                    let root_li_triggers = $(this).parent('div').parent('div').parent('li').parent('ul').parent('li').children('div').children('.parent_element_trigger');
                    let parent_ul_of_form = $(this).parent('div').parent('div').parent('li').parent('ul');
                    let parent_li_of_ul = $(this).parent('div').parent('div').parent('li').parent('ul').parent('li');
                    let parent_li_of_form = $(this).parent('div').parent('div').parent('li');

                    $(parent_li_of_ul).addClass('preloader_in_li');
                    $(parent_li_of_ul).append('<span class="preloader_body"></span>');

                    if (name.length > 0) {
                        let new_category = {
                            id: that.getRandomInt(20, 200),
                            name: name,
                            parent: parent_id,
                            child: [],
                        }

                        axios.post('/admin/blog/store-category-from-blog-create', new_category)
                            .then((res) => {

                                new_category.id = res.data.id;

                                // make new li
                                let new_li = `<li>
                                                <div class="element">
                                                    <input type="checkbox" value="${new_category.id}" class="form-control">
                                                    <i class="fa fa-folder"></i>
                                                    <div>${name}</div>
                                                    <div data-id="${new_category.id}" class="add_sub_category">
                                                        <a href="#">
                                                            <i class="fa fa-plus"></i> Add sub-category
                                                        </a>
                                                    </div>
                                                    <div class="parent_element_trigger  d-none ">
                                                        <i data-action="expand" class="fa fa-plus hide_plus"></i>
                                                        <i data-action="collapse" class="fa fa-minus show_plus"></i>
                                                    </div>
                                                </div>
                                            </li>`;

                                // new category_append
                                $(parent_ul_of_form).append(new_li);

                                // new add form remove
                                $(parent_li_of_form).remove();

                                // d-block triggers
                                $(root_li_triggers).removeClass('d-none');
                                $(root_li_triggers).addClass('d-block');

                                // add new category in category array
                                that.add_new_category_to_parent_category(that.categories, parent_id, new_category);
                                that.draw_left_line();

                                $(parent_li_of_ul).removeClass('preloader_in_li');
                                $('.preloader_body').remove();
                            })

                    } else {
                        $('#new_category_input_value').addClass('border border-danger');
                        $('#new_category_input_value').siblings('.alert_box').removeClass('d-none');
                        $('#new_category_input_value').siblings('.alert_box').addClass('d-block');

                        $(parent_li_of_ul).removeClass('preloader_in_li');
                        $('.preloader_body').remove();
                    }

                    // console.log(parent_id, name, new_category);
                })
            },

            getRandomInt: function (min, max) {
                min = Math.ceil(min);
                max = Math.floor(max);
                return Math.floor(Math.random() * (max - min) + min); //The maximum is exclusive and the minimum is inclusive
            },

            add_new_category_to_parent_category: function (arr, parent_id, new_category) {
                for (let index = 0; index < arr.length; index++) {
                    const element = arr[index];
                    if (element.id == parent_id) {
                        // this.category_html = '';
                        element.child.push(new_category);

                        // console.log(new_category);
                        // re render category html
                        // this.array_depth(this.categories);

                        setTimeout(() => {
                            this.add_new_form_action();
                        }, 300);
                        break;
                    }
                    if (element.child !== undefined) {
                        this.add_new_category_to_parent_category(element.child, parent_id, new_category);
                    }
                }
            },

            permutation: function () {
                let temp_array = [];
                let results = [];
                this.variation_permutaion = [];

                for (let index = 0; index < this.selected_variant_options.length; index++) {
                    const element = this.selected_variant_options[index];
                    temp_array[index] = [];
                    for (let index2 = 0; index2 < element.option_values_json.length; index2++) {
                        const element2 = element.option_values_json[index2].name;
                        temp_array[index].push(element2);
                    }
                }

                // console.log(temp_array);
                // this.variation_permutaion = temp_array;

                for (let index = 0; index < temp_array.length; index++) {
                    const values = temp_array[index];

                    if (results.length == 0) {
                        results = values;
                    } else {
                        let new_results = [];
                        for (let index2 = 0; index2 < results.length; index2++) {
                            const result = results[index2];

                            for (let index3 = 0; index3 < values.length; index3++) {
                                const value = values[index3];
                                new_results.push(result + ', ' + value);
                            }
                        }

                        this.variation_permutaion = results = new_results;
                    }
                }

                if (this.variation_permutaion.length == 0) {
                    this.variation_permutaion = temp_array[0];
                }

                // for (let index = 0; index < results.length; index++) {
                //     const element = results[index];
                //     console.log(element);
                // }
            },

            check_url_exists: function (url) {
                axios.post('/admin/blog/url-check', {
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
                this.form_data.url = this.form_data.title;
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

        },
        computed: {
            // ...window.getters([
            //     'get_auth_info',
            // ]),
        }
    });
}
