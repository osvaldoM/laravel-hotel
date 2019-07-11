<?php

namespace App\Http\Controllers;

use App\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{

    private $images_folder_path = 'images/hotels/';
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
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip_code' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|file',
            'image_name' => 'nullable |'
        ]);

        $request_data = $request->all();

        if(!empty($request->image)) {
            $file = $request->file('image');
            $filename = $file->hashName();

            Storage::disk('local')->put( $this->images_folder_path, $file);

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
        $validatedData = $request->validate([
            'name' => 'nullable',
            'address' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'zip_code' => 'nullable',
            'phone_number' => 'nullable',
            'email' => 'nullable|email',
            'image' => 'nullable|file',
            'image_name' => 'nullable'
        ]);
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

    public function showImage($image_name) {
        return Storage::disk('local')->download("$this->images_folder_path$image_name");
    }
}
