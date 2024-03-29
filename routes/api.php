<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::get('/rooms/{room}/room_info', 'RoomController@booked_dates');
    Route::resource('hotels', HotelController::class);
    Route::resource('room_types', RoomTypeController::class);
    Route::resource('room_capacities', RoomCapacityController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('pricings', PricingController::class);
    Route::resource('bookings', BookingController::class);
    Route::get('/bookings/by_date/{time}', 'BookingController@get_bookings_on_date')->name('bookings.by_date');

    Route::get('/room_types/{room_type}/pricing', 'RoomTypeController@pricing');

});
