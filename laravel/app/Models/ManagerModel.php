<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

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

        if (!empty($result)) {
            $result = $result[0];

            $verify = password_verify($password, $result['password']);

            if ($verify) {
                return $result;
            }
        }

        return 0;
    }

    public function getManagerByID($id)
    {

        $query = Self::query();

        $query = $query->select('id', 'name', 'email', 'phone', 'role', 'admin_approval');
        $query = $query->where('id', '=', $id);
        $result = $query->first();

        return $result;
    }

 
    public function getManagerByEmail($email)
    {

        $query = Self::query();

        $query = $query->select('id');
        $query = $query->where('email', '=', $email);
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

    public function insertManager($post) {
        $data = new Self();
        $data->name = $post['name'];
        $data->email = $post['email'];
        $data->phone = $post['phone'];
        $data->role = $post['role'];
        $data->password = Hash::make($post['password']);
        $insert = $data->save();
        return $data->id;
    }
}