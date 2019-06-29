<?php

namespace App\Http\Controllers;

use App\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(RoomType::all());
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
            'name' => 'required|string'
        ]);
        return RoomType::firstOrCreate(['name' => $request->name], $request->all(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomType  $room_type
     * @return \Illuminate\Http\Response
     */
    public function show(RoomType $room_type)
    {
        return $room_type;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomType $roomType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomType  $room_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomType $room_type)
    {
        $request->validate([
            'name' => 'nullable|string'
        ]);
        if($room_type->update($request->all())) {
            return response()->json($room_type);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomType  $room_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomType $room_type)
    {
        if($room_type->delete()) {
            return response()->json($room_type);
        };
    }

    public function pricing(RoomType $room_type){
        if($room_type->pricing) {
            return $room_type->pricing;
        }
        return new RoomType();
    }
}
