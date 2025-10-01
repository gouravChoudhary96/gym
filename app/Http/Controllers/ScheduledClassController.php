<?php

namespace App\Http\Controllers;

use App\Events\ClassCanceled;
use App\Models\ClassType;
use App\Models\ScheduledClass;
use Illuminate\Http\Request;

class ScheduledClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all scheduled classes for the authenticated instructor
        $scheduledClasses = auth()->user()->scheduledClasses()->with('classType')->upcoming()->get();
        return view('instructor.upcoming', compact('scheduledClasses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get all class types for the dropdown
        $classTypes = ClassType::all();
        return view('instructor.schedule', compact('classTypes'));
    }

    /**
     *  Store a Scheduled Class in storage.
     */
    public function store(Request $request)
    {
        $date_time = $request->input('date') . ' ' . $request->input('time');

        $request->merge([
            'date_time' => $date_time,
            'instructor_id' => auth()->id(),
        ]);

        $validated =   $request->validate([
            'class_type_id' => 'required|exists:class_types,id',
            'date_time' => 'required|date|unique:scheduled_classes,date_time|after:now',
            'instructor_id' => 'required',
        ]);
         ScheduledClass::create($validated);
        return redirect()->route('schedule.index')->with('success', 'Class Add successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScheduledClass $schedule)
    {

        if (auth()->user()->cannot('delete', $schedule)) {
            abort(403);
        }

        $this->authorize('delete', $schedule);

        ClassCanceled::dispatch($schedule);

        // Detach all members from the canceled class
        $schedule->members()->detach();

        // Notify members about the cancellation
        
        // Delete the scheduled class
        $schedule->delete();



        return redirect()->route('schedule.index')->with('success', 'Class deleted successfully.');
    }
}
