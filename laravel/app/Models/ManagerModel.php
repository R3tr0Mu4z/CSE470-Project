<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerModel extends Model
{
    use HasFactory;

    protected $table = 'manager';


    public function insert($e) {
        $this->create($e);
    }

    public function getManager($email, $password)
    {

        $query = Self::query();

        $query = $query->select('id', 'password', 'admin_approval', 'role');
        $query = $query->where('email', '=', $email);



        $result = $query->get()->toArray();

        
        if (empty($result[0])) {
            exit;
        }
        $result = $result[0];

        $verify = password_verify($password, $result['password']);

        if ($verify) {
            return $result;
        }
    }

    public function getManagerByID($id)
    {

        $query = Self::query();

        $query = $query->select('id', 'name', 'email', 'phone', 'role', 'admin_approval');
        $query = $query->where('id', '=', $id);
        $result = $query->first();

        return $result;
    }

 
    
    public function getAllManagers()
    {

        $query = Self::query();

        $query = $query->select('id', 'name', 'email', 'phone', 'role');
        $result = $query->get()->toArray();

        return $result;
    }

    public function deleteManager($id) {
        $query = Self::query();
        $delete = $query->select('id')
        ->where('id', '=', $id)
        ->delete();
        return $delete;
    }

    public function updateManager($manager_id, $data) {
        $update = Self::where('id', $manager_id)
        ->update($data);
        return $update;
    }
}