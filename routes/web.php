<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/about', [WebsiteController::class, 'about']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auth-check', function(){return Auth::check();});
Route::get('/auth-info', function(){return Auth::user();});
Route::post('/auth-login', 'WebsiteController@auth_login');
Route::post('/user-registration', 'WebsiteController@user_registration');

Route::get('/', 'WebsiteController@index')->name('website_index');
Route::get('/products', 'WebsiteController@products')->name('website_products');
Route::get('/writer-books/{slug}', 'WebsiteController@writer_books')->name('website_writer_books');
Route::get('/offers', 'WebsiteController@offers')->name('website_offers');
Route::get('/writers', 'WebsiteController@writers')->name('website_writers');
Route::get('/books/{main_category_name}/{main_category_id}', 'WebsiteController@products')->name('website_main_category_products');
Route::get('/books/category/{category_name}/{category_id}', 'WebsiteController@products')->name('website_category_products');
Route::post('/sumbit_contact', 'WebsiteController@sumbit_contact')->name('website_sumbit_contact');
Route::get('/contact', 'WebsiteController@contact')->name('website_contact');

Route::get('/photo-graph', 'WebsiteController@photograph')->name('website_photograph');
Route::get('/photo-graph-show/{id}', 'WebsiteController@photograph_details')->name('website_photograph_details');
Route::get('/video-graph', 'WebsiteController@videograph')->name('website_videograph');
Route::get('/review', 'WebsiteController@review')->name('website_review');
Route::get('/poribeshok', 'WebsiteController@poribeshok')->name('website_poribeshok');

Route::get('/blogs', 'WebsiteController@blogs')->name('website_blogs');
Route::get('/get-blogs-json', 'WebsiteController@get_blogs_json')->name('website_get_blogs_json');
Route::get('/blog-details/{url}', 'WebsiteController@blog_details')->name('website_blog_details');

Route::post('/product/search/json', 'JsonController@product_search_json')->name('product_search_json');
Route::get('/writer-products/{slug}/json', 'JsonController@writer_products_json')->name('writer_products_json');
Route::get('/offer-products/json', 'JsonController@offer_products_json')->name('offer_products_json');
Route::get('/get-single-product/json/{id}', 'JsonController@get_single_product_json')->name('get_single_product_json');
Route::get('/get-product/{chunk_size}/{chunk_no}/json', 'JsonController@get_product')->name('get_product_json');
Route::get('/get-main-category-product/{category_id}/{chunk_size}/{chunk_no}/json', 'JsonController@get_main_category_product')->name('get_main_category_product_json');
Route::get('/get-category-product/{category_id}/{chunk_size}/{chunk_no}/json', 'JsonController@get_category_product')->name('get_category_product_json');

// Route::get('/products/category/{main_category}', 'WebsiteController@main_category_products')->name('website_main_category_products');
// Route::get('/products/category/{main_category}/all-product-json', 'WebsiteController@main_category_products_json')->name('website_main_category_products_json');

// Route::get('/products/category/{main_category}/{category}', 'WebsiteController@category_products')->name('website_category_products');
// Route::get('/products/category/{main_category}/{category}/all-product-json', 'WebsiteController@category_products_json')->name('website_category_products_json');

// Route::get('/products/category/{main_category}/{category}/{sub_category}', 'WebsiteController@sub_category_products')->name('website_sub_category_products');
// Route::get('/products/category/{main_category}/{category}/{sub_category}/all-product-json', 'WebsiteController@sub_category_products_json')->name('website_sub_category_products_json');

Route::get('/product-details/{product}', 'WebsiteController@details')->name('website_product_details');
Route::get('/cart', 'WebsiteController@cart')->name('website_cart');

Route::get('/checkout', 'WebsiteController@checkout')->name('website_checkout');
Route::post('/checkout-submit', 'WebsiteController@checkout_submit')->name('website_checkout_submit');
Route::get('/print-invoice', 'WebsiteController@print_invoice')->name('website_print_invoice');

Route::post('/store-subscriber', 'WebsiteController@store_subscriber')->name('website_store_subscriber');
Route::get('/get-comments/{id}', 'WebsiteController@get_comments')->name('website_get_comments');
Route::post('/store-comment', 'WebsiteController@store_comment')->name('website_store_comment');

Route::post('/store-blog-comment', 'WebsiteController@store_blog_comment')->name('website_store_blog_comment');

// Route::post('/checkout-confirm','WebsiteController@checkout_confirm')->name('check_out_confirm')->middleware('auth');
// Route::get('/checkout_success','WebsiteController@checkout_success')->name('checkout_success')->middleware('auth');
// Route::post('/save_checkout_information','CheckOutController@save_checkout_information')->name('save_checkout_information')->middleware('auth');
// Route::get('/get_latest_checkout_information','CheckOutController@get_latest_checkout_information')->name('get_latest_checkout_information')->middleware('auth');

Route::get('/account', 'WebsiteController@account')->name('website_account');
Route::get('/wishlist', 'WebsiteController@wishlist')->name('website_wishlist');
Route::get('/contact', 'WebsiteController@contact')->name('website_contact');
// Route::get('/learn-vue', 'WebsiteController@vue')->name('website_vue');

Route::group([
    'prefix' => 'json',
], function () {

    Route::get('/get-auth-information', 'WebsiteController@get_auth_information')->name('get_auth_information');
    Route::get('/search-product', 'WebsiteController@search_product')->name('search_product');
    Route::get('/get-min-max-price', 'WebsiteController@get_min_max_price_json')->name('product_get_min_max_price_json');
    Route::get('/get-all-category', 'WebsiteController@get_all_category_json')->name('product_get_all_category_json');
    Route::get('/get-all-size', 'WebsiteController@get_all_size_json')->name('product_get_all_size_json');
    Route::get('/get-all-color', 'WebsiteController@get_all_color_json')->name('product_get_all_color_json');

    Route::get('/latest-products-json/{paginate}', 'WebsiteController@latest_product_json')->name('product_latest_product_json');
    Route::get('/wanted-products-json/{paginate}', 'WebsiteController@wanted_product_json')->name('product_wanted_product_json');
    Route::get('/latest-deals-products-json', 'WebsiteController@latest_deals_product_json')->name('product_latest_deals_product_json');
    Route::get('/category-products-json/{main_category_id}/{category_id}', 'WebsiteController@category_product_json')->name('product_category_product_json');

    Route::get('/show-product-json/{product}', 'WebsiteController@show_product_json')->name('product_show_product_json');
    Route::get('/get-product-related-info-json/{product}', 'WebsiteController@get_product_related_info_json')->name('product_get_product_related_info_json');

    Route::get('/get-comment-list/{product_id}', 'WebsiteController@get_comment_list')->name('get_comment_list');
    Route::post('/submit-comment', 'WebsiteController@submit_comment')->name('submit_comment')->middleware('auth');

    Route::post('/custom-login','Auth\LoginController@custome_login')->name('custom_login');
    Route::post('/custom-register','Auth\LoginController@custom_register')->name('custom_register');
});

Route::group([
    'prefix' => 'dashboard',
    'middleware' => ['auth'],
    'namespace' => 'Admin'
], function () {

    Route::get('/', 'AdminController@index')->name('admin_index');
    Route::resource('banner', 'BannerController');
});

// user management
Route::group([
    'prefix' => 'user',
    'middleware' => ['super_admin'],
    'namespace' => 'Admin'
], function () {
    Route::get('/index', 'UserController@index')->name('admin_user_index');
    Route::get('/view/{id}', 'UserController@view')->name('admin_user_view');
    Route::get('/create', 'UserController@create')->name('admin_user_create');
    Route::post('/store', 'UserController@store')->name('admin_user_store');
    Route::get('/edit/{id}', 'UserController@edit')->name('admin_user_edit');
    Route::post('/update', 'UserController@update')->name('admin_user_update');
    Route::post('/delete', 'UserController@delete')->name('admin_user_delete');

    Route::post('/test', 'UserController@test')->name('admin_user_test');
});

// order management
Route::group([
    'prefix' => 'orders',
    'middleware' => ['super_admin'],
    'namespace' => 'Admin'
], function () {
    Route::get('/', 'OrderController@orders')->name('admin_order_index');
    Route::get('/get-all', 'OrderController@all_orders')->name('admin_all_orders');
    Route::get('/show/{slug}', 'OrderController@show')->name('admin_show_order');
    Route::post('/change-status', 'OrderController@change_status')->name('admin_change_status');
});

// pathok management
Route::group([
    'prefix' => 'pathok',
    'middleware' => ['super_admin'],
    'namespace' => 'Admin'
], function () {
    Route::get('/review', 'PathokController@review')->name('admin_review_index');
    Route::get('/review-json', 'PathokController@review_json')->name('admin_review_json_index');
    Route::post('/review-create', 'PathokController@review_create')->name('admin_review_create_index');
    Route::post('/review-update', 'PathokController@review_update')->name('admin_review_update_index');
    Route::post('/review-delete', 'PathokController@review_delete')->name('admin_review_delete_index');

    Route::get('/photograph', 'PathokController@photograph')->name('admin_photograph_index');
    Route::get('/photograph-json', 'PathokController@photograph_json')->name('admin_photograph_json_index');
    Route::post('/photograph-create', 'PathokController@photograph_create')->name('admin_photograph_create_index');
    Route::post('/photograph-update', 'PathokController@photograph_update')->name('admin_photograph_update_index');
    Route::post('/photograph-delete', 'PathokController@photograph_delete')->name('admin_photograph_delete_index');

    Route::get('/videograph', 'PathokController@videograph')->name('admin_videograph_index');
    Route::get('/videograph-json', 'PathokController@videograph_json')->name('admin_videograph_json_index');
    Route::post('/videograph-create', 'PathokController@videograph_create')->name('admin_videograph_create_index');
    Route::post('/videograph-update', 'PathokController@videograph_update')->name('admin_videograph_update_index');
    Route::post('/videograph-delete', 'PathokController@videograph_delete')->name('admin_videograph_delete_index');

    Route::get('/poribeshok', 'PathokController@poribeshok')->name('admin_poribeshok_index');
    Route::get('/poribeshok-json', 'PathokController@poribeshok_json')->name('admin_poribeshok_json_index');
    Route::post('/poribeshok-create', 'PathokController@poribeshok_create')->name('admin_poribeshok_create_index');
    Route::post('/poribeshok-update', 'PathokController@poribeshok_update')->name('admin_poribeshok_update_index');
    Route::post('/poribeshok-delete', 'PathokController@poribeshok_delete')->name('admin_poribeshok_delete_index');
});

// role management
Route::group([
    'prefix' => 'user-role',
    'middleware' => ['super_admin'],
    'namespace' => 'Admin'
], function () {
    Route::get('/index', 'UserRoleController@index')->name('admin_user_role_index');
    Route::get('/view/{id}', 'UserRoleController@view')->name('admin_user_role_view');
    Route::get('/create', 'UserRoleController@create')->name('admin_user_role_create');
    Route::post('/store', 'UserRoleController@store')->name('admin_user_role_store');
    Route::get('/edit', 'UserRoleController@edit')->name('admin_user_role_edit');
    Route::post('/update', 'UserRoleController@update')->name('admin_user_role_update');
    Route::post('/delete', 'UserRoleController@delete')->name('admin_user_role_delete');
});

Route::group([
    'prefix' => 'admin/product',
    'middleware' => ['super_admin'],
    'namespace' => 'Product'
], function () {

    // basic_page
    Route::resource('product', 'ProductController');
    Route::get('/${id}/json','ProductController@get_product_json')->name('product.get_product_json');

    // Route::get('/brand','BrandController@index')->name('brand.index');
    // Route::get('/brand/get/{id}','BrandController@get')->name('brand.get');
    // Route::get('/brand/create','BrandController@create')->name('brand.create');
    // Route::get('/brand/show/{id}','BrandController@show')->name('brand.show');
    // Route::get('/brand/edit/{id}','BrandController@edit')->name('brand.edit');
    // Route::post('/brand','BrandController@store')->name('brand.store');
    // Route::put('/brand/{id}','BrandController@update')->name('brand.update');
    // Route::delete('/brand/{id}','BrandController@destroy')->name('brand.destroy');

    Route::resource('brand', 'BrandController');
    Route::resource('main_category', 'MainCategoryController');
    Route::resource('category', 'CategoryController');
    Route::resource('sub_category', 'SubCategoryController');
    Route::resource('color', 'ColorController');
    Route::resource('size', 'SizeController');
    Route::resource('unit', 'UnitController');
    Route::resource('status', 'StatusController');
    Route::resource('writer', 'WriterController');
    Route::resource('translator', 'TranslatorController');
    Route::resource('publication', 'PublicationController');
    Route::resource('vendor', 'VendorController');

    Route::get('/get-all-cateogory-selected-by-main-category/{main_category_id}', 'CategoryController@get_category_by_main_category')->name('get_all_cateogory_selected_by_main_category');
    Route::get('/get-all-sub-cateogory-selected-by-category/{category_id}', 'CategoryController@get_sub_category_by_category')->name('get_all_sub_category_by_category');
    Route::get('/get-all-main-category-josn', 'MainCategoryController@get_main_category_json')->name('get_main_category_json');
    Route::get('/get-all-category-josn', 'CategoryController@get_category_json')->name('get_category_json');
});


Route::group([
    'prefix' => 'admin/blog',
    'middleware' => ['super_admin'],
    'namespace' => 'Blog'
], function () {

    Route::get('/blog-comment', 'BlogController@blog_comment')->name('admin_blog_comment');
    Route::get('/comment-list/{id}', 'BlogController@get_commentjson')->name('admin_blog_get_commentjson');
    Route::post('/comment-accept', 'BlogController@comment_accept')->name('admin_blog_comment_accept');
    Route::get('/comment-delete/{id}', 'BlogController@comment_delete')->name('admin_blog_comment_delete');

    Route::get('/', 'BlogController@list')->name('admin_blog_list');
    Route::get('/list/json', 'BlogController@list_json')->name('admin_blog_list_json');
    Route::get('/get-json/{id}', 'BlogController@get_json')->name('admin_blog_get_json');
    Route::get('/create', 'BlogController@create')->name('admin_blog_create');
    Route::get('/edit/{id}', 'BlogController@edit')->name('admin_blog_edit');
    Route::post('/url-check', 'BlogController@url_check')->name('admin_blog_url_check');
    Route::post('/store', 'BlogController@store')->name('admin_blog_store');
    Route::post('/update', 'BlogController@update')->name('admin_blog_update');
    Route::get('/destroy/{id}', 'BlogController@destroy')->name('admin_blog_destroy');

    Route::get('/categories', 'BlogCategoryController@categories')->name('admin_blog_categories');
    Route::get('/categories_tree_json', 'BlogCategoryController@categories_tree_json')->name('admin_blog_categories_tree_json');
    Route::get('/create-category', 'BlogCategoryController@create_category')->name('admin_blog_create_category');
    Route::get('/edit-category/{id}/{category_name}', 'BlogCategoryController@edit_category')->name('admin_blog_edit_category');
    Route::get('/edit-data/{id}', 'BlogCategoryController@category_data')->name('admin_blog_category_data');
    Route::post('/categorie-url-check', 'BlogCategoryController@categorie_url_check')->name('admin_blog_categorie_url_check');
    Route::post('/store-category', 'BlogCategoryController@store_category')->name('admin_blog_store_category');
    Route::post('/store-category-from-blog-create', 'BlogCategoryController@store_category_from_blog_create')->name('admin_blog_store_category_from_blog_create');
    Route::post('/update-category', 'BlogCategoryController@update_category')->name('admin_blog_update_category');
    Route::post('/rearenge-category', 'BlogCategoryController@rearenge_category')->name('admin_blog_rearenge_category');
});

Route::group([
    'prefix' => 'file-manager',
    'middleware' => ['auth'],
    'namespace' => 'Admin'
], function () {

    Route::post('/store-file', 'FileManagerController@store_file')->name('admin_fm_store_file');
    Route::get('/get-files', 'FileManagerController@get_files')->name('admin_fm_get_files');
    Route::delete('/delete-file/{image}', 'FileManagerController@delete_file')->name('admin_fm_delete_file');
});

Route::group([
    'prefix' => 'blank',
    'middleware' => ['auth'],
    'namespace' => 'Admin'
], function () {

    // basic_page
    Route::get('/index', 'AdminController@blade_index')->name('admin_blade_index');
    Route::get('/create', 'AdminController@blade_create')->name('admin_blade_create');
    Route::get('/view', 'AdminController@blade_view')->name('admin_blade_view');
});

Route::get('/test', function (Request $request) {
    $orders = App\Models\Order::get();
    foreach ($orders as $item) {
        $item->status = rand(2,6);
        $item->payment_code = rand(100000,999999);
        $item->payment_number = '016'.rand(100000000,999999999);
        $item->save();
    }
    dd($request->all());
})->name('route name');

Route::get('/get-custom-logout',function(){
    Auth::logout();
    return redirect('/');
});
