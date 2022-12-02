<?php

namespace App\Http\Controllers;
use App\Models\CustomerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Customer;

class CustomersList extends Controller
{

    
    private $is_admin;
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
            $this->is_admin = true;
            return $next($req);
        }, ['except' => []]);
    }

    public function listCustomers() {
        $customers = CustomerModel::getAllCustomers();
        $customer_objects = [];
        foreach($customers as $customer) {
            $customer_objects[$customer['id']] = new Customer($customer['id']);
        }
        $this->customers = $customer_objects;

        return $this->customers;
    }

    public function viewCustomer($id) {
        if (!$this->is_admin) {exit;}
        $customer = new Customer($id);
        $customer = $customer->getCustomerDetails();
        return view('parts.admin.view_customer', ['customer' => $customer]);
    }

}

