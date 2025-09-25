<?php

namespace App\Http\Controllers;

use App\Models\ScheduledClass;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create()
    {
        $scheduledClasses  = ScheduledClass::upcoming()
            ->with('classType', 'instructor')
            ->noteBooked()
            ->oldest()->get();

        return view('member.book')->with('scheduledClasses', $scheduledClasses);
    }

    public function store(Request $request)
    {
        $request->validate([
            'scheduled_class_id' => 'required|exists:scheduled_classes,id',
        ]);

        auth()->user()->bookings()->attach($request->scheduled_class_id);

        return redirect()->route('booking.index')->with('success', 'Class booked successfully.');
    }


    public function index(Request $request)
    {
        $user = $request->user();
        $bookings = $user->bookings()->upcoming()->get();

        return view('member.upcoming')->with('bookings', $bookings);
    }

    public function destroy(int $id)
    {
        auth()->user()->bookings()->detach($id);
        return redirect()->route('booking.index')->with('success', 'Booking cancelled successfully.');
    }
}
