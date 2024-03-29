<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    private $images_folder_path = 'images/rooms/';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Room::with('roomType', 'roomType.pricing')->get());
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
        $request_data = $request->all();

        $request->validate([
            'name' => 'nullable|string',
            'image' => 'required|file',
            'room_type_id' => 'required|numeric',
            'hotel_id' => 'nullanle|numeric',
        ]);
        if(!empty($request->image)) {
            $file = $request->file('image');
            $filename = $file->hashName();

            Storage::disk('local')->put( $this->images_folder_path, $file);

            $request_data['image_name'] = $filename;
        }
        $request_data['hotel_id'] = $request_data['hotel_id'] ?? Hotel::firstOrCreate([], [])->id;
        return Room::create($request_data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        return $room;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'nullable|string',
            'image' => 'nullable|file',
            'room_type_id' => 'nullable|numeric',
            'room_id' => 'nullable|numeric',
        ]);

        $request_data = $request->all();

        if(!empty($request->image)) {
            $file = $request->file('image');
            $filename = $file->hashName();

            $file->storeAs($this->images_folder_path, $filename);
            $request_data['image_name'] = $filename;
        }
        if($room->update($request_data)) {
            return response()->json($room);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        if($room->delete()) {
            return response()->json($room);
        };
    }

    public function showImage($image_name) {
        return Storage::disk('local')->download("$this->images_folder_path$image_name");
    }

    public function booked_dates(Room $room) {
        $booked_dates = $room->bookings()->select(['start_date', 'end_date'])->get();
        $room_info = $room->load('roomType', 'roomType.pricing');
        return response()->json(['booked_dates' => $booked_dates, 'room_info' => $room_info]);
    }
}
