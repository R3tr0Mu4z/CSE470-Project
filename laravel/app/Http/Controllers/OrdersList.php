<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Customer;
use App\Http\Controllers\FoodItem;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderModel;

class OrdersList extends Controller
{

    private $food_item_ids = [];
    private $quantity_of_foods = [];
    private $customer_id = null;
    private $order_status = 'pending';
    private $time_ordered = null;
    private $total = 0;

    public function __construct()
    {

        $this->middleware('auth:api', ['except' => ['viewOrder']]);

        $this->middleware(function($req, $next){
            $id = $req->session()->get('administrative_manager_id');

            if (empty($id)) {
                return Redirect::to('/');
            }
            $approval = $req->session()->get('admin_approval');
            if ($approval == 0) {
                echo "Your administrative rights require approval.";
                echo "<br/>";
                echo "Please click here to <a href='/manager/logout'>log in</a> again to see if you are approved";
                exit;
            }
            $this->admin_id = $id;
            $this->admin_approval = 1;
            return $next($req);
        }, ['except' => ['getCustomerOrders']]);

    }



    public function getCustomerOrders()
    {
        $this->customer_id = Customer::get_customer();
        $result = OrderModel::getCustomerOrders($this->customer_id);


        foreach($result as $r) {
            $data = [];
            $data['id'] = $r['id'];
            $data['total'] = $r['cost'];
            $data['time'] = $r['created_at'];
            $data['status'] = $r['status'];
            $data['foods'] = [];

            $foods = explode(",", $r['foods']);
            $quantities = explode(",", $r['quantity']);

            $i = 0;
            foreach ($foods as $food) {
                $food_object = new FoodItem($food);
                $data['foods'][$i]['name'] = $food_object->getName();
                $data['foods'][$i]['image'] = $food_object->getImage();
                $data['foods'][$i]['cost'] = $food_object->getPrice()*$quantities[$i];
                $data['foods'][$i]['quantity'] = $quantities[$i];
                $i++;
            }
            $orders[] = $data;
        }

        return response()->json($orders, 200);

    }

    public function listOrders() {
        $orders = OrderModel::getAllOrders();
        $order_objects = [];
        foreach($orders as $order) {
            $order_objects[$order['id']] = new Order($order['id']);
        }
        $this->orders = $order_objects;

        return $this->orders;
    }

    public function viewOrder($id) {
        $order = new Order($id);
        $order->exitIfOrderDoesntExit();
        return view('parts.admin.view_order', ['order' => $order]);
    }


}

