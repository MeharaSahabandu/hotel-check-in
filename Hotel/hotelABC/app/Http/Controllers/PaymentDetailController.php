<?php

namespace App\Http\Controllers;

use App\Models\payment_detail;
use App\Http\Requests\Storepayment_detailRequest;
use App\Http\Requests\Updatepayment_detailRequest;

class PaymentDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            DB::table('payment_details')->get()
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
    public function store(Storepayment_detailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(payment_detail $payment_detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payment_detail $payment_detail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatepayment_detailRequest $request, payment_detail $payment_detail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payment_detail $payment_detail)
    {
        //
    }
}
