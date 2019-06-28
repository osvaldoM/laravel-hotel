<?php

namespace App\Http\Controllers;

use App\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{

    private $images_folder_path = 'images/hotels';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Hotel::all());
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

        if(!empty($request->image)) {
            $file = $request->file('image');
            $filename = $file->hashName();

            $file->storeAs($this->images_folder_path, $filename);
            $request_data['image_name'] = $filename;
        }

        return Hotel::create($request_data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $hotel_id
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {
        return $hotel;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {
        $request_data = $request->all();

        if(!empty($request->image)) {
            $file = $request->file('image');
            $filename = $file->hashName();

            $file->storeAs($this->images_folder_path, $filename);
            $request_data['image_name'] = $filename;
        }
        if($hotel->update($request_data)) {
            return response()->json($hotel);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        //
    }
}
