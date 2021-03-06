<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
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
            'message' => 'User created successfully!',
            'data' => Package::withCount(['products'])->get(),
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        Validate Data
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        //Set Data Object
        $package = new Package();
        $package->name = strtoupper($request->name);
        //Check status HTTP
        if ($package->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'User created successfully!',
                'data' => Package::withCount(['products'])->orderBy('id', 'desc')->get(),
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        //Validate Data
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        //Set Data Object
        $package->name = strtoupper($request->name);
        //Check status HTTP
        if ($package->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'Category updated successfully!',
                'data' => Package::withCount(['products'])->orderBy('id', 'desc')->get(),
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Package $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        //
    }
}
