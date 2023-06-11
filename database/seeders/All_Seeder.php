<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Color;
use App\Models\img;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class All_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category                                   = new Category();
        $category->id                               = 1;
        $category->name                             = 'Danh mục 1';
        $category->save();

        $category                                   = new Category();
        $category->id                               = 2;
        $category->name                             = 'Danh mục 2';
        $category->save();


        $product                                   = new Product();
        $product->id                               = 1;
        $product->name                             = 'sanpham';
        $product->categories_id                    = 1;
        $product->price                            = 2000;
        $product->description                      ="abc";
        $product->save();

        $product                                   = new Product();
        $product->id                               = 2;
        $product->name                             = 'sanpham2';
        $product->categories_id                    = 2;
        $product->price                            = 4000;
        $product->description                      ="abcd";
        $product->save();


        $size                                     = new Size();
        $size->id                               = 1;
        $size->namesize                         = 's';
        $size->product_id                       = 1;
        $size->quantity                         = 1;
        $size->save();

        $size                                     = new Size();
        $size->id                               = 2;
        $size->namesize                         = 'l';
        $size->product_id                       = 2;
        $size->quantity                         = 1;
        $size->save();
          
        $color                                     = new Color();
        $color->id                               = 1;
        $color->namecolor                         ='Black';
        $color->product_id                       = 1;
        $color->save();

        $color                                     = new Color();
        $color->id                               = 2;
        $color->namecolor                         ='white';
        $color->product_id                       = 2;
        $color->save();



        $img                                     = new img();
        $img->id                               = 1;
        $img->img_product                       ='1684161709-corevaluejpg.jpg';
        $img->product_id                       = 1;
        $img->save();

        $img                                     = new img();
        $img->id                               = 2;
        $img->img_product                       ='1684162277-historyjpg.jpg';
        $img->product_id                       = 2;
        $img->save();

    }
}
