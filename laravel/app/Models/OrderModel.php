<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public function getOrder($id) {
        $order_query = Self::query();
        $order_query = $order_query->select('*');
        $order_query = $order_query->where('id', '=', $id);
        $order = $order_query->first();
        return $order;
    }

    public function getRestaurantOrders($restaurant_id) {
        $order_query = Self::query();
        $order_query = $order_query->select('*');
        $order_query = $order_query->where('restaurant', '=', $restaurant_id);
        $order_query_results = $order_query->get()->toArray();
        return $order_query_results;
    }

    public function changeStatus($order_id, $status) {
        $order_query = Self::query();
        $order_query = $order_query->select('*');
        $order_query = $order_query->where('id', '=', $order_id);
        $order_query_result = $order_query->update(['status' => $status]);
        return $order_query_result;
    }

    public function insertOrder($food_item_ids, $quantity_of_foods, $customer_id, $total, $restaurant_id) {
        $data = new Self();
        $data->foods = implode(",", $food_item_ids);
        $data->quantity = implode(",", $quantity_of_foods);
        $data->customer = $customer_id;
        $data->cost = $total;
        $data->restaurant = $restaurant_id;
        $insert = $data->save();
        return $insert;
    }


    public function getCustomerOrders($customer) {
        $order_query = Self::query();
        $order_query = $order_query->select('*');
        $order_query = $order_query->where('customer', '=', $customer)->orderBy('id', 'desc');
        $order = $order_query->get()->toArray();
        return $order;
    }

    public function getCustomerOrder($id, $customer) {
        $order_query = Self::query();
        $order_query = $order_query->select('*');
        $order_query = $order_query->where('id', '=', $id);
        $order_query = $order_query->where('customer', '=', $customer);
        $order = $order_query->first();
        return $order;
    }


    public function getAllOrders()
    {
        $order_query = Self::query();
        $order_query = $order_query->select('*');
        $result = $order_query->get()->toArray();
        return $result;

    }


    public function deleteOrder($id) {
        $query = Self::query();
        $delete = $query->select('id')
        ->where('id', '=', $id)
        ->delete();
        return $delete;
    }
}