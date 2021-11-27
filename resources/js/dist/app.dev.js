"use strict";

var _vuex = require("vuex");

function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue')["default"]; // import vuex

var _require = require('./store/index'),
    store = _require["default"]; // pagination


Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('productSingleBody', require('./components/productComponents/productSingleBody.vue')["default"]);
Vue.component('homeRecentBody', require('./components/productComponents/homeRecentBody.vue')["default"]);
Vue.component('homeCategoryProductBody', require('./components/productComponents/homeCategoryProductBody.vue')["default"]);
Vue.component('latestDeal', require('./components/productComponents/widget/latestDeal.vue')["default"]);
Vue.component('productDetails', require('./components/productComponents/productDetails.vue')["default"]);
Vue.component('productHeaderCart', require('./components/productComponents/productHeaderCart.vue')["default"]);
Vue.component('cartDetails', require('./components/productComponents/cartDetails.vue')["default"]);
Vue.component('checkOut', require('./components/productComponents/checkOut.vue')["default"]);
Vue.component('invoice', require('./components/productComponents/invoice.vue')["default"]);
Vue.component('banner', require('./components/frontend/banner.vue')["default"]);
Vue.component('categoryProducts', require('./components/productComponents/categoryProducts.vue')["default"]);
Vue.component('search', require('./components/frontend/search.vue')["default"]);
Vue.component('productComment', require('./components/productComponents/productComment.vue')["default"]);

if (document.getElementById('productList')) {
  var app = new Vue({
    el: "#productList",
    store: store,
    data: function data() {
      return {
        category_product_paginate_info: {}
      };
    },
    methods: _objectSpread({}, (0, _vuex.mapActions)(['fetch_recent_product_list', 'fetch_product_by_category_list']), {
      trigger_product_category_list: function trigger_product_category_list(page_no) {
        this.category_product_paginate_info.page = page_no;
      }
    }),
    created: function created() {
      var that = this;
      setTimeout(function () {
        $('.category_product_part .page-link').on('click', function () {
          var info = $(this).children('span').data('category');
          that.category_product_paginate_info.main_category_id = info.main_category_id;
          that.category_product_paginate_info.category_id = info.category_id;
          that.fetch_product_by_category_list(that.category_product_paginate_info);
        });
      }, 500);
    },
    watch: {
      get_home_category_product_list: {
        handler: function handler() {
          var that = this;
          setTimeout(function () {
            $('.category_product_part .page-link').off().on('click', function () {
              var info = $(this).children('span').data('category');
              that.category_product_paginate_info.main_category_id = info.main_category_id;
              that.category_product_paginate_info.category_id = info.category_id;
              that.fetch_product_by_category_list(that.category_product_paginate_info);
            });
          }, 500);
        },
        deep: true
      }
    },
    computed: _objectSpread({}, (0, _vuex.mapGetters)(['get_recent_product_list', 'get_home_category_product_list']))
  });
}

if (document.getElementById('product_modal_vue')) {
  var _app = new Vue({
    el: "#product_modal_vue",
    store: store
  });
}

if (document.getElementById('productCart')) {
  var _app2 = new Vue({
    el: "#productCart",
    store: store
  });
}

if (document.getElementById('productCartDetails')) {
  var _app3 = new Vue({
    el: "#productCartDetails",
    store: store,
    computed: _objectSpread({}, (0, _vuex.mapGetters)(['get_sub_total']))
  });
}

if (document.getElementById('ceckOutBody')) {
  var _app4 = new Vue({
    el: "#ceckOutBody",
    store: store,
    computed: _objectSpread({}, (0, _vuex.mapGetters)(['get_sub_total']))
  });
}

if (document.getElementById('invoiceBody')) {
  var _app5 = new Vue({
    el: "#invoiceBody",
    store: store,
    computed: _objectSpread({}, (0, _vuex.mapGetters)(['get_sub_total']))
  });
}

if (document.getElementById('banner_carousel')) {
  var _app6 = new Vue({
    el: "#banner_carousel",
    store: store,
    computed: {// ...mapGetters([
      //     'get_sub_total'
      // ]),
    }
  });
}

if (document.getElementById('category_products')) {
  var _app7 = new Vue({
    el: "#category_products",
    store: store
  });
}

if (document.getElementById('search_box')) {
  var _app8 = new Vue({
    el: "#search_box",
    store: store
  });
}

if (document.getElementById('product_comment')) {
  var _app9 = new Vue({
    el: "#product_comment",
    store: store
  });
}