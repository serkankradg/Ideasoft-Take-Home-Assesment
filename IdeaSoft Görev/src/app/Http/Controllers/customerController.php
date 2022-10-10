<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;

class customerController extends Controller
{
    public function ekle() {
        customer::create([
            "name"=>"Kaptan Devopuz",
            "revenue"=>1505.95,
        ]);
    }
}
