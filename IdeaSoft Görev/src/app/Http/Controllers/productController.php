<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;

class productController extends Controller
{
    public function ekle() {
        products::create([
            "name"=>"Black&Decker A7062 40 Parça Cırcırlı Tornavida Seti",
            "category"=>1,
            "price"=>120.75,
            "stock"=>10,
        ]);

        products::create([
            "name"=>"Reko Mini Tamir Hassas Tornavida Seti 32'li",
            "category"=>1,
            "price"=>49.50,
            "stock"=>10,
        ]);

        products::create([
            "name"=>"Viko Karre Anahtar - Beyaz",
            "category"=>2,
            "price"=>11.28,
            "stock"=>10,
        ]);

        products::create([
            "name"=>"Legrand Salbei Anahtar, Alüminyum",
            "category"=>2,
            "price"=>22.80,
            "stock"=>10,
        ]);

        products::create([
            "name"=>"Schneider Asfora Beyaz Komütatör",
            "category"=>2,
            "price"=>12.95,
            "stock"=>10,
        ]);
    }
}
