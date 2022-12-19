<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\ManagerModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        },  ['except' => ['index', 'signUp', 'signIn', 'deleteManager', 'logout']]);
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

        return empty($id) ? view('manager_signup') : Redirect::to('/owned-restaurants/');
    }


    public function signUp(Request $request, $post, $type)
    {
        $data = [];
        $data['name'] = $post['name'];
        $data['email'] = $post['email'];
        $data['phone'] = $post['phone'];
        $data['password'] = $post['password'];


        if ($type == 'restaurant_manager') {
            $data['role'] = 'restaurant_manager';
        } else {
            $data['role'] = 'administrative_manager';
        }

        if (Self::emailExists($post['email'])) {
            echo "Error : Email already exists";
            exit;
        }
        

        
        $insert = ManagerModel::insertManager($data);

        if ($insert) {
            if ($data['role'] == 'administrative_manager') {
                $request->session()->put('administrative_manager_id', $insert);
                $request->session()->put('admin_approval', 0);
                $request->session()->save();
                return 1;
            } else {
                $request->session()->put('restaurant_manager_id', $insert);
                $request->session()->save();
                return 1;
            }

        }
        return 0;
        
    }


    public function signIn(Request $request, $post)
    {

        $result = ManagerModel::getManager($post['email'], $post['password']);
        
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
        return 0;
        
    }

    public function emailExists($email) {
        $email = ManagerModel::getManagerByEmail($email);
        return $email ? true : false;
    }
    
    public function deleteManager($id) {
        $delete = ManagerModel::deleteManager($id);
        return Redirect::to("/admin/managers/");
    }


    public function editManager($id, Request $req) {

        Self::exitIfManagerDoesntExit($id);

        $manager = new Manager($id);
        return view('edit_manager', ['manager' => $manager]);
    }

    public function updateManager(Request $request) {
        $data = [];

        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'role' => 'required',
            'admin_approval' => 'required',
        ]);
 
        if ($validator->fails()) {
            echo "Error : Please make sure all the inputs are given.";
            exit;
        }


        $validated = $validator->validated();

        Self::exitIfManagerDoesntExit($validated['id']);

        $data['name'] = $validated['name'];
        $data['email'] = $validated['email'];
        $data['phone'] = $validated['phone'];
        $data['role'] = $validated['role'];
        $data['admin_approval'] = $validated['admin_approval'];
        $update = ManagerModel::updateManager($validated['id'], $data);
        return $update ? Redirect::to("/admin/managers/edit/{$validated['id']}") : exit;
    }

    public function exitIfManagerDoesntExit($id = null) {
        if (empty($id)) {
            $id = $this->id;
        }
        $manager = ManagerModel::getManagerByID($id);
        return empty($manager) ? print_r('Error : Manager does not exist').exit : null;
    }

    public function logout(Request $request) {
        $request->session()->flush();
        $request->session()->save(); 

        return Redirect::to("/");
    }

    
}

