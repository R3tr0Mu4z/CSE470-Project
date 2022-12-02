<?php

namespace App\Http\Controllers;
use App\Models\ManagerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Manager;

class ManagersList extends Controller
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

    public function listManagers() {
        $managers = ManagerModel::getAllManagers();
        $manager_objects = [];
        foreach($managers as $manager) {
            $manager_objects[$manager['id']] = new Manager($manager['id']);
        }
        $this->managers = $manager_objects;

        return $this->managers;
    }

    public function viewManager($id) {
        $manager = new Manager($id);
        $manager = $manager->getManagerDetails();
        return view('parts.admin.view_manager', ['manager' => $manager]);
    }

}

