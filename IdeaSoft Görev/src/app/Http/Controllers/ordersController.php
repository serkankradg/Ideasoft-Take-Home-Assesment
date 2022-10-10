<?php

namespace App\Http\Controllers;

use App\Models\basket;
use App\Models\customer;
use App\Models\products;
use Illuminate\Http\Request;

class ordersController extends Controller
{
    public $orders, $solution;

    public function __construct() {
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
                "category" => $key->category,
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
        $this->orders = array(
            1 => [
                "id" => 1,
                "customerId" => $customer,
                "items" => $array,
                "total" => $toplam
            ]
        );
    }

    public function getOrders($orderTotal,$orderId)
    {
        $order = $this->orders[$orderId];
        $output = [
            "orderId" => 1,
            "discounts" => $this->solution,
            "totalDiscount" => $order['total'],
            "discountedTotal" => $orderTotal
        ];
        return json_encode($output);
    }

    public function applyDiscount($orderId)
    {
        $order = $this->orders[$orderId];
        $rules = [
            '10_percent_over_1000' => 'tenPercentOrderThousand',
            'buy_6_get_1' => 'buyFiveGetOne',
            'buy_2_percent_over_10' => 'buyTwoTenPercent',
        ];
        foreach ($rules as $rule) {
            $order = $this->$rule($order);
        }
        return $order;
    }

    private function tenPercentOrderThousand($order)
    {
        if ($order['total'] > 1000) {
            $discount = $order['total'] - $order['total'] * 0.9;
            $subtotal = $order['total'] = $order['total'] * 0.9;
            $this->solution[]=
            $array = [
                "discountReason" => "10_percent_over_1000",
                "discountAmount" => $discount,
                "subtotal" => $subtotal
            ];
        }
        return $order;
    }

    private function buyFiveGetOne($order)
    {
        $category = 0;
        for ($i=0; $i<count($order['items']); $i++) {
            if ($order['items'][$i]['category'] == 2) {
                $category += $order['items'][$i]['quantity'];
                if ($category > 5) {
                    $orderControl = $order['items'][$i]['unitPrice'];
                    $success=true;
                }
            }
        }
        if ($success==true) {
            $order['total'] -= $orderControl;
            $discount = $orderControl;
            $subtotal = $order['total'];
            $this->solution[]=
            $array = [
                "discountReason" => "buy_6_get_1",
                "discountAmount" => $discount,
                "subtotal" => $subtotal
            ];
        }
        return $order;
    }

    private function buyTwoTenPercent($order)
    {
        $category = 0; $min = 0;
        for ($i=0; $i<count($order['items']); $i++) {
            if ($order['items'][$i]['category'] == 1) {
                $category += $order['items'][$i]['quantity'];
                if ($category > 1) {
                    $minArray[] = $order['items'][$i]['unitPrice'];
                    $min = min($minArray);
                }
            }
        }
        $discount = $min * 0.2;
        $subtotal = $order['total'] -= $discount;
        if ($min!=0) {
            $this->solution[]=
            $array = [
                "discountReason" => "buy_2_percent_over_10",
                "discountAmount" => $discount,
                "subtotal" => $subtotal
            ];
        }
        return $order;
    }
}
$orderClass = new ordersController();
$orderId = 1;
$order = $orderClass->applyDiscount($orderId);
echo "total price: ".$order['total'];
echo $orderClass->getOrders($order['total'],$orderId);
