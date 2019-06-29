<?php

namespace App\Http\Controllers;

use App\Pricing;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'rack_rate' => 'required|min:0',
            'min_stay_length' => 'required|numeric|min:1',
            'max_stay_length' => 'nullable|numeric|min:1|gt:min_stay_length',
            'services_included' => 'nullable|string',
            'room_type_id' => 'required',
        ]);
        return Pricing::updateOrCreate(['room_type_id' => $request->room_type_id], $request->all(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function show(Pricing $pricing)
    {
        return $pricing;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function edit(Pricing $pricing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pricing $pricing)
    {
        $request->validate([
            'rack_rate' => 'nullable',
            'min_stay_length' => 'nullable|numeric|min:1',
            'max_stay_length' => 'nullable|numeric|min:1|gt:min_stay_length',
            'services_included' => 'nullable|string',
            'room_type_id' => 'nullable',
        ]);
        if($pricing->update($request->all())) {
            return response()->json($pricing);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pricing $pricing)
    {
        if($pricing->delete()) {
            return response()->json($pricing);
        };
    }
}
