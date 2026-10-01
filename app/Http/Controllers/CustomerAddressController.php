<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class CustomerAddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view customers');
    }

    public function index(Customer $customer): JsonResponse
    {
        $addresses = $customer->addresses()->orderBy('id')->get();

        return response()->json([
            'customer_id' => $customer->id,
            'addresses' => $addresses->map(fn (Address $address) => [
                'id' => $address->id,
                'customer_id' => $address->customer_id,
                'address_title' => $address->address_title,
                'mobile' => $address->mobile,
                'country' => $address->country,
                'state' => $address->state,
                'city' => $address->city,
                'address_1' => $address->address_1,
                'address_2' => $address->address_2,
                'postcode' => $address->postcode,
            ])->values(),
        ]);
    }
}
