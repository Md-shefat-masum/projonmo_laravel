<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Product::truncate();

        DB::table('main_category_product')->truncate();
        DB::table('category_product')->truncate();
        DB::table('product_sub_category')->truncate();
        DB::table('color_product')->truncate();
        DB::table('product_size')->truncate();
        DB::table('product_unit')->truncate();
        DB::table('product_vendor')->truncate();
        DB::table('product_writer')->truncate();
        DB::table('product_publication')->truncate();
        DB::table('image_product')->truncate();

        $book_names = [
            "তিনিই আমার রব",
            "ফেরা ২",
            "যে জীবন মরীচিকা",
            "জীবনের ওপারে",
            "সবর",
            "কাজের মাঝে রবের খোঁজে",
            "হৃদয় জাগার জন্য",
            "জীবন পথে সফল হতে",
            "সুখের নাটাই",
            "সেইসব দিনরাত্রি",
            "তিনিই আমার রব (২য় খণ্ড)",
            "ওয়াসওয়াসা (শয়তানের কুমন্ত্রণা)",
            "অনেক আঁধার পেরিয়ে",
            "বিপদ যখন নিয়ামাত",
            "সবর ও শোকর",
            "কিয়ামুল লাইল",
            "দরজা এখনও খোলা",
            "সিসাঢালা প্রাচীর",
            "কলবুন সালীম (নির্মল অন্তর, নির্মল জীবন)",
            "বিপদ যখন নিয়ামাত (২)",
        ];

        for ($i = 0; $i < 20; $i++) {

            $product = new Product();
            $product->name = $book_names[$i];
            $product->brand_id = rand(1, Brand::count());
            $product->tax = 15;
            $product->price = rand(200, 600);
            $product->sku = 'SKU' . rand(500, 5000);
            $product->stock = rand(700, 1000);
            $product->discount = rand(0, 20);
            $product->expiration_date = Carbon::now()->year . '-12-12';
            $product->minimum_amount = rand(10, 20);
            $product->free_delivery = rand(0, 1);
            $product->total_view = rand(50, 200);
            $product->description = "
                <p>
                    তুমি যে পথে হাঁটছ, ওটা অন্ধকারের পথ। বিন্দুমাত্র আলো নেই ওখানে। ও পথ যতই পাড়ি দেবে, ততই হারিয়ে যাবে নিকষকালো আঁধারে। তুমি অন্ধকারে হাঁটবে আর পথহারা হবে। আঁধারের বাঁদুরেরা তোমায় ভয় দেখাবে ক্ষণে ক্ষণে। একাকী তুমি আরও ভীতসন্ত্রস্ত হয়ে পড়বে। ভীত-বিহ্বল চিত্তে একসময় ক্লান্ত-পরিশ্রান্ত হয়ে তলিয়ে যাবে অতল ভয়ানক খাঁদে।
                    পথিক! তোমায় আলোর পথে ডাকছি। এখানে আলোআঁধারি খেলা নেই।
                </p>
                <p>
                    নেই আঁধারের বাঁদুরের কোনো স্থান। চারিদিকে কেবল আলো আর আলো। এখানকার আলো থেকে ছিটকে-পড়া পুণ্যময় রশ্মিগুলো, তোমায় নিত্য ডাকছে হাতছানি দিয়ে। এ পথে হাঁটলে তুমি কখনও পথহারা হবে না। অতল তলে হারিয়ে যাবে না। এর শেষটা মিশে আছে জান্নাতের সাথে। এ পথের দরজা এখনও খোলা আছে।
                    এসো তবে ফিরে।তাওবার ওপর রচিত বক্ষ্যমাণ গ্রন্থটি ইতিহাসের সবচেয়ে প্রাচীন গ্রন্থগুলোর একটি। জগদ্বিখ্যাত ইমাম ইবনু আবিদ দুনইয়া রহ.
                    -এতে তাওবাহ বিষয়ক নবীজির হাদীস, সাহাবী এবং পরবর্তী প্রজন্মের উক্তিগুলো সংকলন করেছেন।
                </p>
            ";
            $product->features = "
                <ul>
                    <li>ভীতসন্ত্রস্ত হয়ে পড়বে</li>
                    <li>তোমায় আলোর পথে ডাকছি</li>
                    <li>অতল তলে হারিয়ে যাবে না</li>
                    <li>গ্রন্থটি ইতিহাসের সবচেয়ে প্রাচীন গ্রন্থগুলোর</li>
                </ul>
            ";
            $product->thumb_image = "dummy_products/" . rand(19, 40) . ".jpg";
            $product->creator = 1;
            $product->created_at = Carbon::now()->toDateTimeString();
            $product->save();
            $product->code = 'PRO-' . Carbon::now()->year . Carbon::now()->month . $product->id;
            $product->slug = Str::slug($product->name) . '-' . Carbon::now()->year . Carbon::now()->month . $product->id;
            $product->save();

            DB::table('main_category_product')->insert(
                ['main_category_id' => rand(1,5), 'product_id' => $product->id]
            );

            DB::table('category_product')->insert([
                ['category_id' => rand(1,5), 'product_id' => $product->id],
                ['category_id' => rand(6,10), 'product_id' => $product->id],
                ['category_id' => rand(11,14), 'product_id' => $product->id]
            ]);

            DB::table('product_sub_category')->insert([
                ['sub_category_id' => 1, 'product_id' => $product->id],
                ['sub_category_id' => 2, 'product_id' => $product->id],
                ['sub_category_id' => 3, 'product_id' => $product->id]
            ]);

            DB::table('color_product')->insert(
                ['color_id' => 1, 'product_id' => $product->id],
                ['color_id' => 2, 'product_id' => $product->id],
                ['color_id' => 3, 'product_id' => $product->id]
            );

            DB::table('product_size')->insert([
                ['size_id' => 1, 'product_id' => $product->id],
                ['size_id' => 2, 'product_id' => $product->id],
                ['size_id' => 3, 'product_id' => $product->id]
            ]);

            DB::table('product_unit')->insert([
                ['unit_id' => 1, 'product_id' => $product->id],
                ['unit_id' => 2, 'product_id' => $product->id],
                ['unit_id' => 3, 'product_id' => $product->id]
            ]);

            DB::table('product_vendor')->insert([
                ['vendor_id' => 1, 'product_id' => $product->id],
                ['vendor_id' => 2, 'product_id' => $product->id],
            ]);

            DB::table('product_writer')->insert([
                ['writer_id' => 1, 'product_id' => $product->id],
                ['writer_id' => 2, 'product_id' => $product->id],
            ]);

            DB::table('product_publication')->insert([
                ['publication_id' => rand(1,5), 'product_id' => $product->id],
                ['publication_id' => rand(6,10), 'product_id' => $product->id],
            ]);

            DB::table('image_product')->insert([
                ['image_id' => rand(20, 25), 'product_id' => $product->id],
                ['image_id' => rand(26, 30), 'product_id' => $product->id],
                ['image_id' => rand(31, 35), 'product_id' => $product->id],
                ['image_id' => rand(36, 40), 'product_id' => $product->id],
            ]);
        }


    }
}
