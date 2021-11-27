<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogCategory::truncate();
        
        BlogCategory::create([
            'id' => 1,
            'name' => 'ইসলাম',
            'url' => '/ইসলাম',
            'description' => '
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book

            ',
            'parent_id' => 0,
            'template_layout_file' => 'default',
            'sort_order' => '0',
            'default_product_sort' => '5',
            'category_image' => 'uploads/category_image/Ks7cgcw4i2MeR7ygbETpp4rTzB7angx7Lb6nxAGf.png',
            'page_title' => 'man\'s fashion',
            'meta_keywords' => 'man, shirt, t-shirt',
            'meta_description' => 'man, shirt, t-shirt',
            'search_keywords' => 'man, shirt, t-shirt',
            'creator' => '1',
            'slug' => '14711man',
            'status' => 1,
            'created_at' => '2021-06-14 22:16:56',
            'updated_at' => '2021-06-15 15:25:47'
        ]);


        BlogCategory::create([
            'id' => 2,
            'name' => 'ইতিহাস',
            'url' => '/ইতিহাস',
            'description' => '
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book

            ',
            'parent_id' => 0,
            'template_layout_file' => 'default',
            'sort_order' => '0',
            'default_product_sort' => '5',
            'category_image' => 'uploads/category_image/dqPQosA3AHli8wMHUFYjAff5rzdrM3WISYOjikcK.png',
            'page_title' => 'man\'s fashion',
            'meta_keywords' => 'man, shirt, t-shirt',
            'meta_description' => 'man, shirt, t-shirt',
            'search_keywords' => 'man, shirt, t-shirt',
            'creator' => '1',
            'slug' => '28461t-shirt',
            'status' => 1,
            'created_at' => '2021-06-14 22:18:16',
            'updated_at' => '2021-06-15 15:03:43'
        ]);


        BlogCategory::create([
            'id' => 3,
            'name' => 'নবীজির সুন্নাহ',
            'url' => '/নবীজির সুন্নাহ',
            'description' => '
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book

            ',
            'parent_id' => 1,
            'template_layout_file' => 'default',
            'sort_order' => '0',
            'default_product_sort' => '5',
            'category_image' => 'uploads/category_image/uXKgzVO3aaML2DB7Dd2wc16FCHRtG9qiPjxsrVai.png',
            'page_title' => 'man\'s fashion',
            'meta_keywords' => 'man, shirt, t-shirt',
            'meta_description' => 'man, shirt, t-shirt',
            'search_keywords' => 'man, shirt, t-shirt',
            'creator' => '1',
            'slug' => '36448jeans-pant',
            'status' => 1,
            'created_at' => '2021-06-14 22:18:41',
            'updated_at' => '2021-06-15 15:23:31'
        ]);


        BlogCategory::create([
            'id' => 4,
            'name' => 'আদব, আখলাক',
            'url' => '/আদব, আখলাক',
            'description' => '
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book

            ',
            'parent_id' => 1,
            'template_layout_file' => 'default',
            'sort_order' => '0',
            'default_product_sort' => '5',
            'category_image' => 'uploads/category_image/4ymZ7Ukx02XT4OpTjNhstkh4snf9xa1eMgNloYZL.png',
            'page_title' => 'man\'s fashion',
            'meta_keywords' => 'man, shirt, t-shirt',
            'meta_description' => 'man, shirt, t-shirt',
            'search_keywords' => 'man, shirt, t-shirt',
            'creator' => '1',
            'slug' => '47713panjabi',
            'status' => 1,
            'created_at' => '2021-06-14 22:18:52',
            'updated_at' => '2021-06-14 22:18:52'
        ]);

    }
}
