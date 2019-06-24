<?php

namespace App\Http\Controllers;

use App\RoomCapacity;
use Illuminate\Http\Request;

class RoomCapacityController extends Controller
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
        return RoomCapacity::create($request->all(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomCapacity  $room_capacity
     * @return \Illuminate\Http\Response
     */
    public function show(RoomCapacity $room_capacity)
    {
        return $room_capacity;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomCapacity  $roomCapacity
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomCapacity $roomCapacity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomCapacity  $room_capacity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomCapacity $room_capacity)
    {
        if($room_capacity->update($request->all())) {
            return response()->json($room_capacity);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomCapacity  $roomCapacity
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomCapacity $room_capacity)
    {
        if($room_capacity->delete()) {
            return response()->json($room_capacity);
        };
    }
}
