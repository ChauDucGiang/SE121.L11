<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;

use App\Models\Country;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'status' => 200,
            'data' => Customer::with(['country', 'products'])->get(),
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate Data
        $request->validate([
            'code' => 'required|string|max:255|unique:customers',
            'email' => 'nullable|email|unique:customers,email',
            'company' => 'required|string',
            'country_id' => 'required|string',
        ]);
        //Set Data Object
        $customer = new Customer();
        $customer->code = $request->code;
        $customer->department = $request->department;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->country_id = $request->country_id;
        $customer->company = $request->company;
        //Check status HTTP
        if ($customer->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'Customer created successfully!',
                'data' => Customer::all(),
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred. Please try again!',
            'data' => Customer::all(),
        ], 500);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return response()->json([
            'status' => 200,
            'data' => $customer,
        ], 200);
    }

    /**
     * Show the form for create the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'status' => 200,
            'data' => Country::all(),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //Validate Data

        $request->validate([
            'code' => 'sometimes|required|string|max:255|unique:customers,code,' . $customer->id,
            'email' => 'nullable|email|unique:customers,email,' . $customer->id,
            'company' => 'required|string',
            'country_id' => 'required|string',
        ]);
        //Set Data Object
        $customer->code = $request->code;
        $customer->department = $request->department;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->country_id = $request->country_id;
        $customer->company = $request->company;
        //Check status HTTP
        if ($customer->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'Customer updated successfully!',
                'data' => Customer::all(),
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred. Please try again!',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //Check status HTTP
        if ($customer->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Customer deleted successfully!',
                'data' => Customer::all(),
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred. Please try again!',
            'data' => Customer::all(),
        ], 500);
    }
}
