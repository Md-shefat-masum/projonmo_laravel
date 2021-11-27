"use strict";

$(function () {
  // remover action on navbar dropdown menu
  $('.has-arrow').on('click', function (e) {
    return e.preventDefault();
  }); // rerender delete function on ajax load html

  var init_delete_function = function init_delete_function() {
    $('.delete_btn').off().on('click', function (e) {
      var _this = this;

      e.preventDefault();

      if (confirm('sure want to delete')) {
        $.ajax({
          url: $(this).attr('href'),
          type: 'delete',
          success: function success(res) {
            $(_this).parents($(_this).data('parent')).remove();
            $(_this).parents('tr').remove();
            $(_this).parents('li').remove();
            Toast.fire({
              icon: 'success',
              title: 'data deleted'
            });
          }
        });
      }
    });
  };

  init_delete_function(); // remove alert on foucus input fields

  $('input').on('focus', function (e) {
    $(this).siblings('span').html('');
  });
  $('select').on('focus', function (e) {
    $(this).siblings('span').html('');
  });
  $('textarea').on('focus', function (e) {
    $(this).siblings('span').html('');
  }); // all insert form ajax

  $('.insert_form').on('submit', function (e) {
    var _this2 = this;

    e.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: formData,
      success: function success(res) {
        console.log(res);
        $(_this2).trigger('reset');
        $('.product_insert_form select').val('').trigger('change');
        $('.note-editable').html('');
        $('.preloader').hide();
        toaster('success', 'data inserted successfully.');
      },
      error: function error(err) {
        // console.log(err.responseJSON.errors);
        var errors = err.responseJSON.errors;

        for (var key in errors) {
          if (Object.hasOwnProperty.call(errors, key)) {
            var element = errors[key];
            $(".".concat(key)).text(element);
          }
        }

        toaster('error', 'check below for errors');
        $('.preloader').hide();
      },
      beforeSend: function beforeSend() {
        $('.preloader').show();
      }
    });
  }); // all update form ajax

  $('.update_form').on('submit', function (e) {
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: formData,
      success: function success(res) {
        $('.preloader').hide();
        toaster('success', 'data updated successfully.');
      },
      error: function error(err) {
        // console.log(err.responseJSON.errors);
        var errors = err.responseJSON.errors;

        for (var key in errors) {
          if (Object.hasOwnProperty.call(errors, key)) {
            var element = errors[key];
            $(".".concat(key)).text(element);
          }
        }

        toaster('error', 'check below for errors');
        $('.preloader').hide();
      },
      beforeSend: function beforeSend() {
        $('.preloader').show();
      }
    });
  }); // component form ajax

  $('.component_form_submit').off().on('click', function () {
    var form = $(this).parents('.component_form');
    var target_select = $(this).parents('.component_form').data('target_select');
    var action = $(this).parents('.component_form').attr('action');
    var inputs = $(form[0]).children('.modal-body').children('.form-group').children('div').children('input');
    var textareas = $(form[0]).children('.modal-body').children('.form-group').children('div').children('textarea');
    var selects = $(form[0]).children('.modal-body').children('.form-group').children('div').children('.select_ontime').children('select'); // let formData = new FormData(form);

    var temp_form = $(document.createElement('form'));
    $(temp_form).attr('method', 'POST');

    for (var key in inputs) {
      if (Object.hasOwnProperty.call(inputs, key)) {
        var element = inputs[key];

        if (parseInt(key) >= 0 && typeof parseInt(key) === "number") {
          $(temp_form).append($(element).clone());
        }
      }
    }

    for (var _key in textareas) {
      if (Object.hasOwnProperty.call(textareas, _key)) {
        var _element = textareas[_key];

        if (parseInt(_key) >= 0 && typeof parseInt(_key) === "number") {
          $(temp_form).append($(_element).clone());
        }
      }
    }

    for (var _key2 in selects) {
      if (Object.hasOwnProperty.call(selects, _key2)) {
        var _element2 = selects[_key2];

        if (parseInt(_key2) >= 0 && typeof parseInt(_key2) === "number") {
          $(temp_form).append($(_element2).clone());
        }
      }
    }

    var formData = new FormData(temp_form[0]);
    $.ajax({
      url: action,
      type: "POST",
      data: formData,
      success: function success(res) {
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
      error: function error(err) {
        // console.log(err.responseJSON.errors);
        var errors = err.responseJSON.errors;

        for (var _key3 in errors) {
          if (Object.hasOwnProperty.call(errors, _key3)) {
            var _element3 = errors[_key3];
            $(".component_form .".concat(_key3)).text(_element3);
          }
        }

        toaster('error', 'check below for errors');
        $('.component_preloader').hide();
      },
      beforeSend: function beforeSend() {
        $('.component_preloader').show();
      }
    }); // console.log(form, action, inputs, textareas, temp_form);
  }); // if another select option change on one select

  $('.parent_select').off().on('change', function () {
    var value = $(this).val();
    var control_url = $(this).data('this_field_control_route');
    var control_class = $(this).data('this_field_will_contorl');
    $.get(control_url + '/' + value, function (res) {
      $('.' + control_class).html(res);
    });
  }); // load option form modal component select

  $('.load_options').on('click', function (e) {
    var _this3 = this;

    e.preventDefault();
    var url = $(this).data('url');
    var control_class = $(this).siblings('select').data('this_field_will_contorl');
    $.get(url, function (res) {
      $(_this3).siblings('select').html(res);

      if (control_class) {
        $('.' + control_class).html('');
      }
    });
  }); // file manager ajax

  var get_all_image = function get_all_image() {
    $.get('/file-manager/get-files', function (res) {
      $('.file_manager_image_list').html(res);
      init_delete_function();
      activate_image_function();
    });
  }; // modal trigger


  var selected_file_input = '';
  $('.input_file_body').on('click', function () {
    get_all_image();
    selected_file_input = $(this).children('input')[0];
  });
  $('.fm_file_importer').on('change', function () {
    var _this4 = this;

    var temp_form = $(document.createElement('form'));
    $(temp_form).attr('method', 'POST');
    $(temp_form).append($(this).clone());
    var formData = new FormData(temp_form[0]);
    $.post('/file-manager/store-file', formData, function (res) {
      if (res) {
        $(_this4).val('');
        get_all_image();
        toaster('success', 'Image Uploaded Successfully');
      }
    });
  });
  var selected_image = [];
  var selected_image_id = [];

  var activate_image_function = function activate_image_function() {
    selected_image = [];
    selected_image_id = [];
    $('.fm_checkbox').on('click', function () {
      var value = $(this).data('name');
      var value_Id = $(this).val();
      var check_exist = selected_image.includes(value);

      if (check_exist) {
        selected_image = selected_image.filter(function (name) {
          return name != value;
        });
        selected_image_id = selected_image_id.filter(function (id) {
          return id != value_Id;
        });
      } else {
        selected_image.push(value);
        selected_image_id.push(value_Id);
      } // console.log(value,selected_image);

    });
  };

  $('#fm_confirm_btn').on('click', function (e) {
    e.preventDefault();

    if (selected_image.length) {
      if ($(selected_file_input)[0].multiple === false) {
        $(selected_file_input).val(selected_image[0]);
        $(selected_file_input).siblings('img').attr('src', '/' + selected_image[0]);
      } else {
        // $(selected_file_input).val(JSON.stringify(selected_image));
        $(selected_file_input).val(JSON.stringify(selected_image_id));
        $(selected_file_input).siblings('img').remove();

        for (var index = 0; index < selected_image.length; index++) {
          var element = selected_image[index];
          $(selected_file_input).parents('.input_file_body').prepend('<img src="/' + element + '" style="height: 50px;margin: 5px;" alt="product image"/>');
        }
      }

      $('#fileManagerModal').modal('hide');
    } else {
      toaster('error', 'no file selected');
    }
  }); // product main category ajax

  $('.product_main_category').on('change', function () {
    var value = $(this).val();
    $.get('/admin/product/get-all-cateogory-selected-by-main-category/' + value, function (res) {
      $('.product_category').html(res);
      $('.product_sub_category').html('');
    });
  }); // product category ajax

  $('.product_category').on('change', function () {
    var value = $(this).val();
    $.get('/admin/product/get-all-sub-cateogory-selected-by-category/' + value, function (res) {
      $('.product_sub_category').html(res);
    });
  });
});