<?php
// database/migrations/2024_01_01_000003_seed_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $products = [
            // Electronics
            ['name'=>'Apple iPhone 15 Pro Max 256GB','description'=>'Latest Apple iPhone with A17 Pro chip, titanium design, 48MP camera system.','category'=>'Electronics','brand'=>'Apple','price'=>134900,'original_price'=>149900,'discount'=>10,'image'=>'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=400&q=80','stock'=>50,'rating'=>4.8,'reviews_count'=>2341,'is_prime'=>true,'is_featured'=>true],
            ['name'=>'Samsung Galaxy S24 Ultra 512GB','description'=>'Galaxy AI, built-in S Pen, 200MP camera, Snapdragon 8 Gen 3.','category'=>'Electronics','brand'=>'Samsung','price'=>124999,'original_price'=>134999,'discount'=>7,'image'=>'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=400&q=80','stock'=>35,'rating'=>4.7,'reviews_count'=>1876,'is_prime'=>true,'is_featured'=>true],
            ['name'=>'Sony WH-1000XM5 Headphones','description'=>'Industry leading noise cancellation, 30hr battery, multipoint connection.','category'=>'Electronics','brand'=>'Sony','price'=>24990,'original_price'=>34990,'discount'=>29,'image'=>'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&q=80','stock'=>80,'rating'=>4.6,'reviews_count'=>5432,'is_prime'=>true,'is_featured'=>false],
            ['name'=>'Apple MacBook Air M3 13-inch','description'=>'Supercharged by M3 chip, 18-hour battery life, 8GB RAM, 256GB SSD.','category'=>'Electronics','brand'=>'Apple','price'=>114900,'original_price'=>119900,'discount'=>4,'image'=>'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400&q=80','stock'=>25,'rating'=>4.9,'reviews_count'=>987,'is_prime'=>true,'is_featured'=>true],
            ['name'=>'boAt Rockerz 450 Bluetooth Headphones','description'=>'40mm dynamic drivers, 15hr playback, foldable design, built-in mic.','category'=>'Electronics','brand'=>'boAt','price'=>1299,'original_price'=>3990,'discount'=>67,'image'=>'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=400&q=80','stock'=>200,'rating'=>4.1,'reviews_count'=>89432,'is_prime'=>true,'is_featured'=>false],
            ['name'=>'Logitech MX Master 3S Mouse','description'=>'8K DPI sensor, ultra-fast scrolling, ergonomic design, USB-C charging.','category'=>'Electronics','brand'=>'Logitech','price'=>8995,'original_price'=>10995,'discount'=>18,'image'=>'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=400&q=80','stock'=>60,'rating'=>4.7,'reviews_count'=>3210,'is_prime'=>true,'is_featured'=>false],

            // Books
            ['name'=>'Atomic Habits by James Clear','description'=>'Tiny changes, remarkable results. #1 New York Times bestseller.','category'=>'Books','brand'=>'Penguin','price'=>499,'original_price'=>799,'discount'=>38,'image'=>'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400&q=80','stock'=>500,'rating'=>4.8,'reviews_count'=>45231,'is_prime'=>true,'is_featured'=>true],
            ['name'=>'Rich Dad Poor Dad','description'=>'What the rich teach their kids about money that the poor and middle class do not.','category'=>'Books','brand'=>'Manjul','price'=>299,'original_price'=>450,'discount'=>34,'image'=>'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400&q=80','stock'=>300,'rating'=>4.6,'reviews_count'=>32100,'is_prime'=>true,'is_featured'=>false],

            // Fashion
            ['name'=>'Levi\'s Men\'s 511 Slim Jeans','description'=>'Slim fit jeans, sits below waist, slim through hip and thigh.','category'=>'Fashion','brand'=>'Levi\'s','price'=>2699,'original_price'=>3999,'discount'=>33,'image'=>'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&q=80','stock'=>150,'rating'=>4.3,'reviews_count'=>12543,'is_prime'=>true,'is_featured'=>false],
            ['name'=>'Nike Air Max 270 Sneakers','description'=>'Max Air unit in the heel for all-day comfort. Breathable mesh upper.','category'=>'Fashion','brand'=>'Nike','price'=>9995,'original_price'=>12995,'discount'=>23,'image'=>'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&q=80','stock'=>90,'rating'=>4.5,'reviews_count'=>8765,'is_prime'=>true,'is_featured'=>true],

            // Home & Kitchen
            ['name'=>'Instant Pot Duo 7-in-1 Electric Pressure Cooker','description'=>'7-in-1: pressure cooker, slow cooker, rice cooker, steamer, sauté, yogurt maker & warmer.','category'=>'Home & Kitchen','brand'=>'Instant Pot','price'=>6999,'original_price'=>9999,'discount'=>30,'image'=>'https://images.unsplash.com/photo-1585515320310-259814833e62?w=400&q=80','stock'=>45,'rating'=>4.6,'reviews_count'=>23456,'is_prime'=>true,'is_featured'=>false],
            ['name'=>'Philips Air Fryer HD9200','description'=>'Rapid Air technology, 1400W, 4.1L capacity, dishwasher safe parts.','category'=>'Home & Kitchen','brand'=>'Philips','price'=>8995,'original_price'=>11995,'discount'=>25,'image'=>'https://images.unsplash.com/photo-1648196789220-d1d9e13d4e06?w=400&q=80','stock'=>55,'rating'=>4.4,'reviews_count'=>7654,'is_prime'=>true,'is_featured'=>false],
        ];

        foreach ($products as &$p) {
            $p['created_at'] = now();
            $p['updated_at'] = now();
        }

        DB::table('products')->insert($products);
    }

    public function down(): void
    {
        DB::table('products')->truncate();
    }
};