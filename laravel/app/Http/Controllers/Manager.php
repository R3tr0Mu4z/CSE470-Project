<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\ManagerModel;
use Illuminate\Support\Facades\Hash;

class Manager extends Controller
{
    private $id = null;
    private $name = null;
    private $email = null;
    private $phone = null;
    private $role = null;
    private $approval_admin = null;

    public function __construct($id = null)
    {
        if (!empty($id)) {
            $manager = ManagerModel::getManagerByID($id);
            if (!empty($manager)) {
                $this->id = $manager['id'];
                $this->name = $manager['name'];
                $this->email = $manager['email'];
                $this->phone = $manager['phone'];
                $this->role = $manager['role'];
                $this->approval_admin = $manager['admin_approval'];
            }
        }


        $this->middleware(function($req, $next){
            $approval = $req->session()->get('admin_approval');

            if ($approval == 1) {
                return $next($req);
            }

            $id = $req->session()->get('restaurant_manager_id');
            if (empty($id)) {
                return Redirect::to('/');
            }
            return $next($req);
        },  ['except' => ['index', 'signUp', 'signIn', 'deleteManager']]);
    }

    public function getID() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getRole() {
        return $this->role;
    }

    public function getApproval() {
        return $this->approval_admin;
    }

    public function getManagerDetails() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'admin_approval' => $this->approval_admin
        ];
    }

    public function index(Request $request)
    {
        $id = $request->session()->get('user_id');
        if (empty($id)) {
            return view('manager_signup');
        } else {
            return Redirect::to('/owned-restaurants/');
        }
    }


    public function signUp(Request $request, $type)
    {
        $data = new ManagerModel;
        $data->name = $request['name'];
        $data->email = $request['email'];
        $data->phone = $request['phone'];
        $data->password = Hash::make($request['password']);

        if ($type == 'restaurant_manager') {
            $data->role = 'restaurant_manager';
        } else {
            $data->role = 'administrative_manager';
        }
        

        
        $insert = $data->save();
        if ($insert) {
            if ($data->role == 'administrative_manager') {
                $request->session()->put('administrative_manager_id', $data->id);
                $request->session()->put('admin_approval', 0);
                $request->session()->save();
                return 1;
            } else {
                $request->session()->put('restaurant_manager_id', $data->id);
                $request->session()->save();
                return 1;
            }

        }
    }


    public function signIn(Request $request)
    {

        $result = ManagerModel::getManager($request['email'], $request['password']);

        if (!empty($result)) {
            if ($result['role'] == "administrative_manager") {
                $request->session()->put('administrative_manager_id', $result['id']);
                $request->session()->put('admin_approval', $result['admin_approval']);
                $request->session()->save(); 
                return 1;
            } else {
                $request->session()->put('restaurant_manager_id', $result['id']);
                $request->session()->save();
                return 1;
            }

        }
    }
    
    public function deleteManager($id) {
        $delete = ManagerModel::deleteManager($id);
        if ($delete) {
            return Redirect::to('/admin/managers/');
        }
    }


    public function editManager($id, Request $req) {
        $manager = new Manager($id);
        return view('edit_manager', ['manager' => $manager]);
    }

    public function updateManager(Request $request) {
        $data = [];
        $data['name'] = $request['name'];
        $data['email'] = $request['email'];
        $data['phone'] = $request['phone'];
        $data['role'] = $request['role'];
        $data['admin_approval'] = $request['admin_approval'];
        $update = ManagerModel::updateManager($request['id'], $data);
        if ($update) {
            return Redirect::to("/admin/managers/edit/{$request['id']}");
        }
    }

    
}

