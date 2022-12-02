<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;

class CustomerModel extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $table = 'customers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getId()
    {
        return $this->id;
    }


    public function insertCustomer($post) {
        $data = new Self();
        $data->name = $post['name'];
        $data->email = $post['email'];
        $data->phone = $post['phone'];
        $data->password =  $post['password'];
        $insert = $data->save();

        return $insert;
    }

    
    public function getCustomer($id) {
        $customer_query = Self::query();
        $customer_query = $customer_query->select('*');
        $customer_query = $customer_query->where('id', '=', $id);
        $customer = $customer_query->first();
        return $customer;
    }

    public function getAllCustomers() {
        $customer_query = Self::query();
        $customer_query = $customer_query->select('id');
        $customer = $customer_query->get()->toArray();
        return $customer;
    }

    public function updateCustomer($customer_id, $data) {
        $update = Self::where('id', $customer_id)
        ->update($data);
        return $update;
    }

    public function deleteCustomer($id) {
        $query = Self::query();
        $delete = $query->select('id')
        ->where('id', '=', $id)
        ->delete();
        return $delete;
    }
}
