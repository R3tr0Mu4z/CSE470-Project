<?php

namespace App\Http\Controllers;
use App\Models\ManagerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Manager;
use App\Http\Controllers\CustomersList;
use App\Http\Controllers\ManagersList;
use App\Http\Controllers\RestaurantsList;

class AdministrativeManager extends Controller
{

    private $admin_id = null;
    private $admin_approval = null;
    
    public function __construct()
    {
        $this->middleware(function($req, $next){
            $id = $req->session()->get('administrative_manager_id');
            if (empty($id)) {
                return Redirect::to('/');
            }
            $approval = $req->session()->get('admin_approval');

            if ($approval == 0) {
                echo "Your administrative rights require approval.";
                exit;
            }
            $this->admin_id = $id;
            $this->admin_approval = 1;
            return $next($req);
        }, ['except' => ['index', 'post', 'view_signIn']]);
    }

    public function index(Request $request)
    {
        $id = $request->session()->get('administrative_manager_id');
        if (empty($id)) {
            return view('admin_signup');
        } else {
            return Redirect::to('/admin/customers/');
        }
    }

    public function post(Request $request) {
        if ($request['type'] == 'sign_up') {
            $result = Manager::signUp($request, 'admin_manager');
            if ($result) {
                return Redirect::to('/admin/customers/');
            }
        }

        if ($request['type'] == 'sign_in') {
            $result = Manager::signIn($request, "admin");
            if ($result) {
                return Redirect::to('/admin/customers/');
            }
        }
    }

    public function view_signIn()
    {
        return view('admin_signin');
    }

    public function viewCustomers() {
        $customers_list = new CustomersList();

        return view('customers', ['customers_list' => $customers_list]);
    }
    

    public function viewManagers() {
        $managers_list = new ManagersList();

        return view('managers', ['managers_list' => $managers_list]);
    }
    

    
    public function viewRestaurants() {
        $restaurants_list = new RestaurantsList();

        return view('restaurants', ['restaurants_list' => $restaurants_list]);
    }

    public function viewOrders() {
        $orders_list = new OrdersList();
        return view('orders', ['orders_list' => $orders_list]);
    }
}

