<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;

class categoryController extends Controller
{
    public function ekle() {
        category::create([
            "name"=>"Kategori 1",
        ]);

        category::create([
            "name"=>"Kategori 2",
        ]);
    }
}
