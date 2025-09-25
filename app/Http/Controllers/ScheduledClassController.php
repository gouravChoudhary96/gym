<?php

namespace App\Http\Controllers;

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
        // $scheduledClasses = ScheduledClass::where('instructor_id', auth()->id())->with('classType')->get();
        $scheduledClasses = auth()->user()->scheduledClasses()->with('classType')->upcoming()->get();
        return view('instructor.upcoming', compact('scheduledClasses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classTypes = ClassType::all();
        return view('instructor.schedule', compact('classTypes'));
    }

    /**
     * Store a newly created resource in storage.
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
             'date_time' => 'required|date|unique:schedule_classes,date_time|after:now',
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

        if(auth()->user()->cannot('delete',$schedule)){
             abort(403);
        }

        // if(auth()->id() !== $schedule->instructor_id){
        //     abort(403);
        // }
        $this->authorize('delete', $schedule);
        $schedule->delete();
        return redirect()->route('schedule.index')->with('success', 'Class deleted successfully.');
    }   
}
