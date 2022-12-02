<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Customer;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\OrderModel;
use App\Http\Controllers\FoodItem;

class Order extends Controller
{

    private $food_item_ids = [];
    private $quantity_of_foods = [];
    private $customer_id = null;
    private $order_status = 'pending';
    private $time_ordered = null;
    private $total = 0;
    private $restaurant_id;
    private $order_id;
    private $food_items = [];
    private $customer = null;
    private $is_admin = 0;

    public function __construct($id = null)
    {
        if (!empty($id)) {
            $order = OrderModel::getOrder($id);
            if (!empty($order)) {
                $this->food_item_ids = $order['foods'];
                $this->quantity_of_foods = $order['quantity'];
                $this->customer_id = $order['customer'];
                $this->total = $order['cost'];
                $this->order_status = $order['status'];
                $this->restaurant_id = $order['restaurant'];
                $this->time_ordered = $order['created_at'];
                $this->order_id = $order['id'];

                $foods = explode(",", $order['foods']);
                foreach($foods as $food) {
                    $this->food_items[] = new FoodItem($food);
                }
                $this->customer = new Customer($order['customer']);
            }
        }

        $this->middleware('auth:api', ['except' => ['markDelivered', 'markCancelled', 'deleteOrder']]);

        $this->middleware(function($req, $next){
            $approval = $req->session()->get('admin_approval');

            if ($approval == 1) {
                $this->is_admin = true;
                return $next($req);
            }

            $id = $req->session()->get('restaurant_manager_id');
            if (empty($id)) {
                return Redirect::to('/');
            }
            $this->restaurant_owner_id = $id;
            return $next($req);
        }, ['except' => ['placeOrder', 'getCustomerOrder']]);
    }

    public function showTotalCost() {
        echo $this->total;
    }

    public function showFoodItems() {
        $data = [];
        $i = 0;
        foreach($this->food_items as $food) {
            $d = [];
            $d['id'] = $food->getID();
            $d['name'] = $food->getName();
            $d['category'] = $food->getCategory();
            $d['price'] = $food->getPrice();
            $d['image'] = $food->getImage();
            $d['quantity'] = explode(",", $this->quantity_of_foods)[$i];
            $data[] = $d;
            $i++;
        }

        return view('parts.order.order_food_items', ['foods' => $data]);
    }

    public function getID() {
        return $this->order_id;
    }


    public function getStatus() {
        return $this->order_status;
    }

    public function getFoodsObjects() {
        return $this->food_items;
    }

    public function getTimeOrdered() {
        return $this->time_ordered;
    }

    public function getCustomer() {
        return $this->customer;
    }

    public function markDelivered(Request $request) {
        $this->order_id = $request['order_id'];
        $update = OrderModel::changeStatus($this->order_id, "Delivered");
        if ($update) {
            if ($this->is_admin) {
                return Redirect::to("/admin/orders/view/{$this->order_id}");
            }
            return Redirect::to("/owned-restaurants-orders/");
        }
    }


    public function markCancelled(Request $request) {
        $this->order_id = $request['order_id'];
        $update = OrderModel::changeStatus($this->order_id, "Cancelled");
        if ($update) {
            if ($this->is_admin) {
                return Redirect::to("/admin/orders/view/{$this->order_id}");
            }
            return Redirect::to("/owned-restaurants-orders/");
        }
    }
    

    public function placeOrder(Request $request)
    {
        $this->customer_id = Customer::get_customer();
        $items = json_decode($request['order'], 1);

        foreach($items as $item) {
            $this->food_item_ids[] = $item['id'];
            $this->quantity_of_foods[] = $item['quantity'];
            $food_obj = new FoodItem($item['id']);
            $this->total = $this->total + $food_obj->getPrice() * $item['quantity'];
            $this->restaurant_id = $food_obj->getRestaurantID();
        }

        $insert = OrderModel::insertOrder($this->food_item_ids, $this->quantity_of_foods, $this->customer_id, $this->total, $this->restaurant_id);

        if ($insert) {
            return response()->json(['type' => 'success', 'message' => 'Order placed!'], 200);
        }

    }

    public function getCustomerOrder($id)
    {
        $result = OrderModel::getCustomerOrder($id, $this->customer_id);
        return response()->json($result, 200);

    }

    public function deleteOrder($id) {
        $delete = OrderModel::deleteOrder($id);
        if ($delete) {
            return Redirect::to('/admin/orders/');
        }
    }

}

