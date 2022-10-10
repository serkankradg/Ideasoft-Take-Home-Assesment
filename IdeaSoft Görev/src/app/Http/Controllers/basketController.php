<?php

namespace App\Http\Controllers;

use App\Models\customer;
use Illuminate\Http\Request;
use App\Models\basket;
use App\Models\products;

class basketController extends Controller
{
    public function ekle($product) {
        $db = customer::first();
        $customer = $db->id;
        $add = basket::create([
            "customer"=>$customer,
            "product"=>$product,
        ]);
        if ($add) {
            return response()->json([
                "message" => "Success => true"
            ]);
        }
    }

    public function sil($product) {
        $delete = basket::where('product', $product)->delete();
        if ($delete) {
            return response()->json([
                "message" => "Success => true"
            ]);
        }
    }

    public function listele() {
        $db = customer::first();
        $customer = $db->id;
        $list = basket::where('customer', $customer)->get();
        $y = basket::where('customer', $customer)->get()->count();
        for ($i=0; $i<$y; $i++) {
            $product = $list[$i];
            $product = $product['product'];
            $productArray[$i]=$product;
        }
        $list = products::whereIn('id', $productArray)->get();
        foreach ($list as $key) {
            $quantity = basket::where('product', $key->id)->get()->count();
            $total = $key->price*$quantity;
            $items = array(
                "productId" => $key->id,
                "quantity" => $quantity,
                "unitPrice" => $key->price,
                "total" => $total
            );
            $array[]=$items;
        }
        $y = count($array);
        $toplam = 0;
        for ($i=0; $i<$y; $i++) {
            $toplam+=$array[$i]['total'];
        }
        $json = array(
            "id" => 1,
            "customerId" => $customer,
            "items" => $array,
            "total" => $toplam
        );
        $json = json_encode($json);
        echo $json;
    }
}
