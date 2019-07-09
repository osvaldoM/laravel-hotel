<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Room;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Booking::all());
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
            'name' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'customer_full_name' => 'required|string',
            'customer_email' => 'required|string',
            'user_id' => 'nullable|numeric',
            'room_id' => 'required|numeric',
        ]);


        $start_date = Carbon::parse($request->start_date);
        $end_date = Carbon::parse($request->end_date);

        if($start_date->greaterThan($end_date)) {
            $errorMessage = array(
                'status' => 'error',
                'message' => 'Check-in date cannot be greater than checkout date!'
            );
            return response()->json($errorMessage, 500);
        }

        $conflicting_bookings = $this->get_conflicting_bookings($start_date, $end_date);

        if(!$conflicting_bookings->isEmpty()) {
            $errorMessage = array(
                'status' => 'error',
                'message' => 'Attempting to book room in occupied dates!'
            );
            return response()->json($errorMessage, 500);
        }

        if(Auth::user()) {
            $request->merge(['user_id'=> Auth::user()->id]);
        }

        return Booking::create($request->all(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        return $booking;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'name' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'customer_full_name' => 'nullable|string',
            'customer_email' => 'nullable|string',
            'user_id' => 'nullable|numeric',
            'room_id' => 'nullable|numeric',
        ]);

        $start_date = Carbon::parse($request->start_date ?? $booking->start_date);
        $end_date = Carbon::parse($request->end_date ?? $booking->end_date);

        if($start_date->greaterThan($end_date)) {
            $errorMessage = array(
                'status' => 'error',
                'message' => 'Check-in date cannot be greater than checkout date!'
            );
            return response()->json($errorMessage, 500);
        }

        $conflicting_bookings = $this->get_conflicting_bookings($start_date, $end_date);

        $conflicting_bookings_without_current_booking = $conflicting_bookings->where('id', '!=', $booking->id);

        if(!$conflicting_bookings_without_current_booking->isEmpty()) {
            $errorMessage = array(
                'status' => 'error',
                'message' => 'Attempting to book room in occupied dates!'
            );
            return response()->json($errorMessage, 500);
        }

        if(Auth::user()) {
            $request->merge(['user_id'=> Auth::user()->id]);
        }
        if($booking->update($request->all())) {
            return response()->json($booking);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        if($booking->delete()) {
            return response()->json($booking);
        };
    }
    private function get_conflicting_bookings($start_date, $end_date) {
        return DB::table('bookings')
            ->whereBetween('start_date', [$start_date->addDays()->toDateTimeString(), $end_date->addDays()->toDateTimeString()])
            ->orWhereBetween('end_date', [$start_date->addDays()->toDateTimeString(), $end_date->addDays()->toDateTimeString()])
            ->get();
    }
}
