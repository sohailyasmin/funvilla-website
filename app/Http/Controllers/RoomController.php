<?php

namespace App\Http\Controllers;

use App\Models\RoomBooking;
use App\Models\SlotRoom;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function slotRoomsParties($id)
    {
        try {

            $booked_slot = RoomBooking::select('room_id')
                ->where("booking_slot_id", $id)
                // ->whereDate('created_at', today())
                ->where('created_at', '>=', now()->subMinutes(15))
                ->where('status', 'OCCUPIED')
                ->get();
            $response = SlotRoom::where("booking_slot_id", $id)
                ->whereNotIn('room_id', $booked_slot->pluck('room_id'))
                ->with('room')
                ->get();

            return response()->json(['data' => $response]);
        } catch (\Exception $e) {

            \Log::error($e);

            return response()->json(['message' => 'An error occurred while processing the request'], 500);
        }
    }
}
