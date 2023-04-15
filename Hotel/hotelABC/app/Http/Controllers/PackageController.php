<?php

namespace App\Http\Controllers;

use App\Models\package;
use App\Http\Requests\StorepackageRequest;
use App\Http\Requests\UpdatepackageRequest;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            //getting all records
            DB::table('packages')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorepackageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepackageRequest $request, package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(package $package)
    {
        //
    }
}
