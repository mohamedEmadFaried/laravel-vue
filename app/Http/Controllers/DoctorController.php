<?php

namespace App\Http\Controllers;

use App\Center;
use App\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($term = null)
    {
        if ($term != null) {
            $doctor= Doctor::where('name', 'like', '%'.$term.'%')->with('center')->get();
            return response()->json($doctor, 200);
        }

        return $this->_allRecord();
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
            'name' => 'required',
            'center_id' => 'required|unique:centers',
        ]);

        Doctor::create([
            'name' => $request->name,
            'center_id' => $request->center_id,
        ]);

        return $this->_allRecord();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        return response()->json($doctor, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|min:6',
        ]);

        $doctor->update([
            'name' => $request->name,
        ]);

        return $this->_allRecord();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        if ($doctor->delete()) {
            return $this->_allRecord();
        } else {
            return response()->json(425, ['delete' => 'Error deleting record']);
        }
    }

    private function _allRecord()
    {
        $doctor= Doctor::with('center')->latest()->paginate(5);
        return response()->json($doctor, 200);
    }
    public function centers()
    {
        $centers = Center::get();
        return response()->json($centers);
    }
}
