<?php

namespace App\Http\Controllers;

use App\Models\guest;
use App\Http\Requests\StoreguestRequest;
use App\Http\Requests\UpdateguestRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            //getting all guests records
            DB::table('guests')->get()
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
    public function store(StoreguestRequest $request)
    {
        $name = $request -> input ('name');
        $contact = $request -> input ('contact');
        $nic = $request -> input ('nic');

        DB::transaction (function() use ($name, $contact, $nic){
            DB::table('guests') -> insertGetId([
                'name' => $name,
                'contact' => $contact,
                'nic' => $nic
            ]);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(guest $guest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(guest $guest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateguestRequest $request, guest $guest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(guest $guest)
    {
        //
    }
}
