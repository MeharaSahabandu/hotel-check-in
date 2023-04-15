<?php

namespace App\Http\Controllers;
use App\Models\room;
use App\Models\booking;
use App\Models\guest;
use App\Models\package;
use App\Http\Requests\StoreroomRequest;
use App\Http\Requests\UpdateroomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{

    //All room details
    public function index()
    {
        return response()->json([
            DB::table('rooms')->get(),
        ]);
    }

    //Show the form for creating a new resource.
    public function create()
    {
        //
    }

    //Store a newly created resource in storage.
    public function store(StoreroomRequest $request)
    {
        $suite = $request -> input ('suite');
        $status = $request -> input ('status');

        DB::transaction (function() use ($suite, $status){
            DB::table('rooms') -> insertGetId([
                'suite' => $suite,
                'status' => $status
            ]);
        });

    }

    //Display the specified resource
    public function show(string $room)
    {
        if ($room == 'available') {
            return response()->json([
                DB::table('rooms')
                ->where('status', 'Available')
                ->get()
            ]);
        }

        return response() -> json ([
            DB::table('rooms') 
            -> where ('status', 'Available') 
            -> where ('suite', $room )
            -> pluck('id')
        ]);
    }

    //Show the form for editing the specified resource.
    public function edit(room $room)
    {
        //
    }

    //Update the specified resource in storage
    public function update(UpdateroomRequest $request, room $room)
    {
        //
    }

    //Remove the specified resource from storage.
    public function destroy(room $room)
    {
        //
    }
}
