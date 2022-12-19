<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\Customer;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Hash;

class CustomerTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function test_Customer()
    {

        $data = [];
        $data['name'] = 'Unit Test';
        $data['email'] = 'unit@test.test';
        $data['phone'] = '123456789';
        $data['password'] =  'test';
        $data['password'] = Hash::make($data['password']);
        $id = CustomerModel::insertCustomer($data);
        $customer = new Customer($id);

        if ($data['name'] == $customer->getName()
        && $data['email'] == $customer->getEmail()
        && $data['phone'] == $customer->getPhone()) {
            CustomerModel::deleteCustomer($id);
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
    }
}
