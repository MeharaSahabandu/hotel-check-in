<?php

namespace App\Http\Controllers;

use App\Models\booking;
use App\Http\Requests\StorebookingRequest;
use App\Http\Requests\UpdatebookingRequest;
use App\Models\room;
use App\Models\guest;
use App\Models\package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    //getting all booking records
    public function index()
    {
        return response()->json([
            DB::table('bookings')->get()
        ]);
    }

    //Show the form for creating a new resource
    public function create()
    {
        //
    }

    //Store a newly created resource in storage.
    public function store(StorebookingRequest $request)
    {
        $name = $request -> input ('name');
        $contact = $request -> input ('contact');
        $nic = $request -> input ('nic');
        $check_in = $request -> input ('check_in');
        $check_out = $request -> input ('check_out');
        $start_date = \Carbon\Carbon::parse($check_in);
        $end_date = \Carbon\Carbon::parse($check_out);
        $stay_type = $request -> input ('stay_type');
        $suite = $request -> input ('suite');
        $room_id = $request -> input ('room_id');
        $paymentDetail_id = $request -> input ('paymentDetail_id');
        $nights = $end_date -> diffInDays ($start_date);

        DB::transaction(function () use ($name, $contact, $nic, $check_in, $check_out, $stay_type, $suite, $room_id, $start_date, $end_date, $paymentDetail_id, $nights) {
            // Check if the guest with the same name already exists
            $existing_guest = DB::table('guests')->where('name', $name)->first();
            if ($existing_guest) {
             $guest_id = $existing_guest->id;
            } else {
                // Insert the new guest
                $guest_id = DB::table('guests')->insertGetId([
                    'name' => $name,
                    'contact' => $contact,
                    'nic' => $nic,
                ]);
            }
            // Check if the room is available
            $room = DB::table('rooms')->where('id', $room_id)->first();
            if (!$room || $room->status !== 'Available') {
                throw new Exception("Room is not available");
            }
            //select the package type considering the stay_type and and the room_suite
            if($suite == 'Standard'){
                if ($stay_type == 'FB'){
                    $package_type =1;
                }else if( $stay_type == 'BB'){
                    $package_type = 2;
                }
            }else if ($suite == 'Deluxe'){
                if ($stay_type == 'FB'){
                    $package_type =3;
                }else if( $stay_type == 'BB'){
                    $package_type = 4;
                }   
            }
            //calculate the subtotal according to the package_type
            if($package_type==1){
                $subtotal = $nights*25000;
            }else if ($package_type==2){
                $subtotal = $nights*15000;
            }else if ($package_type==3){
                $subtotal = $nights*40000;
            }else if ($package_type==4){
                $subtotal = $nights*25000;
            }
            $tax= 0.1 * $subtotal;
            $total = $tax + $subtotal;
            $booking_id = DB::table('bookings')->insertGetId([
                "guest_id" => $guest_id,
                "room_id" => $room_id,
                "package_type" => $package_type,
                "check_in" => $check_in,
                "check_out" => $check_out,
            ]);
            DB:: table ('payment_details') -> insertGetId([
                'package_type' => $package_type,
                'booking_id' => $booking_id,
                'subtotal' => $subtotal,
                'tax' => 0.1*$subtotal,
                'total' => $total,
            ]);
            // Update the status of the room as 'Booked' when the room is getting booked
            DB::table('rooms')->where('id', $room_id)->update(['status' => 'Booked']);
        });
    }

    //Display the specified resource.
    public function show(booking $booking)
    {
        //
    }

    //Show the form for editing the specified resource
    public function edit(booking $booking)
    {
        //
    }

    //Update the specified resource in storage
    public function update(UpdatebookingRequest $request, booking $booking)
    {
        //
    }

    //Remove the specified resource from storage
    public function destroy(booking $booking)
    {
        //
    }
    
    //display current room details
    public function currentStatus(){
        $bookedRooms = DB::table('bookings')
                        ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
                        ->join('guests', 'bookings.guest_id', '=', 'guests.id')
                        ->join ('packages', 'bookings.package_type', '=', 'packages.package_type')
                        ->select('rooms.id','rooms.status','rooms.suite','guests.name', 'bookings.check_in','bookings.check_out', 'packages.stay_type','guests.contact', 'guests.nic')
                        ->where('bookings.check_out' , '>', now());
    
        $availableRooms = DB::table('bookings')
                        ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
                        ->leftJoin('guests', 'bookings.guest_id', '=', 'guests.id')
                        ->leftJoin('packages', 'bookings.package_type', '=', 'packages.package_type')
                        ->select(
                            'rooms.id',
                            'rooms.status',
                            'rooms.suite',
                            DB::raw("CASE WHEN bookings.check_out < NOW() THEN '-' ELSE guests.name END AS name"),
                            DB::raw("CASE WHEN rooms.status = 'Available' THEN '-' ELSE bookings.check_in END AS check_in"),
                            DB::raw("CASE WHEN bookings.check_out < NOW() THEN '-' ELSE bookings.check_out END AS check_out"),
                            DB::raw("CASE WHEN rooms.status = 'Available' THEN '-' ELSE packages.stay_type END AS stay_type"),
                            DB::raw("CASE WHEN bookings.check_out < NOW() THEN '-' ELSE guests.contact END AS contact"),
                            DB::raw("CASE WHEN bookings.check_out < NOW() THEN '-' ELSE guests.nic END AS nic")
                        )
                        ->where('rooms.status', 'Available');
        $allRooms = $bookedRooms->union($availableRooms)->get();
        return response()->json($allRooms);
    }
}